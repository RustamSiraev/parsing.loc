<?php

namespace App\Http\Controllers\Parsing;

use App\Models\Parsing;
use App\Models\Result;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use phpQuery;
use phpQueryObject;

require_once 'phpQuery/phpQuery/phpQuery.php';

set_time_limit(0);

class ParsingController
{
    const ITERATIONS_LIMIT = 5000;
    const EXCEPTIONS_FILE = 'logs/exceptions.txt';
    const USER_AGENTS_FILE = 'logs/user_agents.txt';

    private string $siteUrl;
    private array $internalLinks = array();
    private array $badLinks = array();
    private array $allLinks = array();
    private array $checkedLinks = array();
    private int $iterations;
    private array $parseSiteUrl;
    private Parsing $parsing;

    /**
     * Получение и исключение URL-адреса из массива $internalLinks,
     * добавление адреса в массив проверенных URL-адресов,
     * если ссылка не битая (на случай повтора этой ссылки)
     * @param int $sleep
     */
    public function runParser(Parsing $parsing, int $sleep = 0)
    {
        $this->parsing = $parsing;
        $this->siteUrl = $parsing->href;
        $this->allLinks[] = $parsing->href;
        $this->internalLinks[] = $parsing->href;
        $this->parseSiteUrl = parse_url($parsing->href);
        $this->iterations = self::ITERATIONS_LIMIT;

        do
        {
            $url = $this->getNextUrl();

            if ($this->checkExceptions($url))
            {
                continue;
            }

            try
            {
                $this->parseLink($url);
            } catch (Exception $e)
            {
                $sleepTime = 7;
                echo $e->getMessage() . ". Sleeping $sleepTime... ";
                sleep($sleepTime);
                $this->parseLink($url);
            }
            sleep($sleep);
        } while (
            $this->internalLinks && $this->hasIterations()
        );

        $this->parsing->update(
            [
                'checked' => count($this->allLinks),
                'broken' => count($this->badLinks),
                'stop' => now(),
                'end' => true
            ]
        );

        return true;
    }

    /**
     * Счетчик итераций
     * @return bool
     */
    private function hasIterations(): bool
    {
        if (!--$this->iterations)
        {
            echo 'Parser has exceeded iterations limit.' . PHP_EOL;
            return false;
        }
        return true;
    }

    /**
     * Получение и исключение URL-адреса из массива $internalLinks,
     * добавление адреса в массив проверенных URL-адресов,
     * если ссылка не битая (на случай повтора этой ссылки)
     * @return string
     */
    private function getNextUrl(): string
    {
        $url = array_shift($this->internalLinks);
        if ($url)
        {
            if (!in_array($url, $this->badLinks))
                $this->checkedLinks[] = $url;
        }
        return $url;
    }

    /**
     * Парсинг страницы для получения URL-адресов
     * @param string $url
     */
    protected function parseLink(string $url)
    {
        if (!in_array($url, $this->badLinks))
        {
            $parseSiteUrl = parse_url($url);
            $data = $this->getData($url, $url)['data'];
            $document = phpQuery::newDocument($data);
            $links = $document->find('a'); //ищем все ссылки на странице

            foreach ($links as $link)
            {
                $pqLink = pq($link); //создаем объект phpQueryObject
                $href = $pqLink->attr('href');

                if ($this->checkExceptions($href))
                {
                    continue;
                }

                if (!preg_match('#^https?://#i', $href))
                {
                    if (str_starts_with($href, '//vk.com/video_ext'))
                    {
                        $href = 'https:' . $href;
                    }
                    elseif (str_starts_with($href, '/'))
                    {
                        $href = $parseSiteUrl['scheme'] . '://' . $parseSiteUrl['host'] . $href;
                    }
                    elseif (str_starts_with($href, './'))
                    {
                        $trimUrl = $url;
                        if (mb_substr($url, -1) != '/')
                            $trimUrl = strrev(strstr(strrev($url), '/'));

                        $href = $trimUrl . ltrim($href, './');
                    }
                    else
                    {
                        $href = rtrim($this->siteUrl, '/') . '/' . $href;
                    }
                }

                //пропускаем если ссылка уже была обработана
                if (in_array($href, $this->internalLinks) || in_array($href, $this->checkedLinks) || in_array($href, $this->badLinks))
                {
                    continue;
                }

                $anchor = $this->getAnchor($pqLink);

                $this->getData($href, $url, $anchor);

                //если ссылка внутрення добавляем ее в массив $internalLinks для дальнейшей обработки
                if (parse_url($href)['host'] == $this->parseSiteUrl['host'])
                {
                    $this->internalLinks[] = $href;
                }
                //иначе добавляем ее в массив проверенных ссылок $checkedLinks
                else
                {
                    if (!in_array($href, $this->badLinks))
                        $this->checkedLinks[] = $href;
                }
            }
        }
    }

    /**
     * Проверка ссылки
     * @param string $url
     * @param string $parent
     * @param string $anchor
     * @return array
     */
    protected function getData(string $url, string $parent = '', string $anchor = ''): array
    {
        //$this->saveLog($url);

        if (!empty($this->parsing)) {
            if ($this->parsing->findOrFail($this->parsing->id)->end)
                exit;
        }

        if (!in_array($url, $this->allLinks))
        {
            $this->allLinks[] = $url;
        }
        $curl = curl_init();
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: ";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => $this->getRandomUserAgent(),
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_REFERER => 'https://www.google.com',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));

        $data['data'] = curl_exec($curl);
        $data['url'] = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        //если ответ не 200, добавляем ссылку в массив битых ссылок $badLinks
        //и данные по этой ссылке в массив $badLinksArr
        if (isset($code) && $code !== 200)
        {
            $this->badLinks[] = $url;
            $data['error'] = true;

            if (!empty($this->parsing)) {
                Result::create([
                    'parsing_id' => $this->parsing->id,
                    'href' => $url,
                    'code' => $code != 0 ? $code : 'bad host',
                    'parent' => $parent,
                    'anchor' => $anchor,
                ]);
            }
        }

        if (!empty($this->parsing)) {
            $this->parsing->update(
                [
                    'checked' => count($this->allLinks),
                    'broken' => count($this->badLinks),
                    'stop' => now(),
                ]
            );
        }
        return $data;
    }

    /**
     * Получение анкор ссылки
     * текст или название первого атрибута
     * @param phpQueryObject $pqLink
     * @return string
     */
    protected function getAnchor(phpQueryObject $pqLink): string
    {
        $text = trim($pqLink->text());
        if ($text)
        {
            return $text;
        }
        return mb_substr(trim($pqLink->html()), 1, stripos(trim($pqLink->html()), ' '));
    }

    /**
     * Получение случайного User-Agent
     * из тестового файла
     * @return string
     */
    protected function getRandomUserAgent(): string
    {
        $userAgents = file_get_contents(self::USER_AGENTS_FILE);

        $userAgents = explode(PHP_EOL, $userAgents);

        $random = mt_rand(0, count($userAgents) - 1);

        return $userAgents[$random];
    }

    protected function saveLog(string $string)
    {
        $file = 'logs/log.txt';
        $str = $string . "\n";
        file_put_contents($file, $str, FILE_APPEND);
    }

    /**
     * Проверка ссылки на исключения
     * @param string|null $url
     * @return bool
     */
    protected function checkExceptions(string $url = null): bool
    {
        if (!$url
            || str_starts_with($url, 'mailto')
            || str_starts_with($url, '#')
            || str_starts_with($url, 'viber')
            || str_starts_with($url, 'skype')
            || str_starts_with($url, 'javascript:')
            || str_starts_with($url, 'tel'))
        {
            return true;
        }

        $exceptionsArr = explode(PHP_EOL, file_get_contents(self::EXCEPTIONS_FILE));

        foreach ($exceptionsArr as $exception)
        {
            if (strpos($url, $exception))
            {
                return true;
            }
        }

        return false;
    }
}

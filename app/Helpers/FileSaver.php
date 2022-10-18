<?php

namespace App\Helpers;

use App\Models\Child;
use Illuminate\Http\UploadedFile;
use Storage;

class FileSaver
{
    /**
     * @param \Illuminate\Http\UploadedFile $request — объект HTTP-запроса
     * @param \App\Models\Child $item — модель
     * @param string $dir — директория, куда будем сохранять файл
     * @return string|null — имя файла изображения для сохранения в БД
     */
    public function upload(UploadedFile $request, $item, string $dir, int $width, int $height): ?string
    {
        $name = $item->image ?? null;

        $source = $request;
        if ($source) { // если было загружено изображение
            // перед загрузкой нового изображения удаляем старое
            if ($item && $item->image) {
                $this->remove($item, $dir);
            }
            $ext = $source->extension();
            // сохраняем загруженное изображение без всяких изменений
            $path = $source->store('catalog/' . $dir . '/source', 'public');
            $path = Storage::disk('public')->path($path); // абсолютный путь
            $name = basename($path); // имя файла
            // создаем уменьшенное изображение 50%
            $dst = 'catalog/' . $dir . '/image/';
            $this->resize($path, $dst, $width/2, $height/2, $ext);
            // создаем уменьшенное изображение 20%
            $dst = 'catalog/' . $dir . '/thumb/';
            $this->resize($path, $dst, $width/5, $height/5, $ext);
        }
        return $name;
    }

    /**
     * Создает уменьшенную копию изображения
     *
     * @param string $src — путь к исходному изображению
     * @param string $dst — куда сохранять уменьшенное
     * @param integer $width — ширина в пикселях
     * @param integer $height — высота в пикселях
     * @param string $ext — расширение уменьшенного
     */
    private function resize(string $src, string $dst, int $width, int $height, string $ext)
    {
        // создаем уменьшенное изображение width x height, качество 100%
        $image = Image::make($src)
            ->heighten($height)
            ->resizeCanvas($width, $height, 'center', false, 'eeeeee')
            ->encode($ext, 100);
        // сохраняем это изображение под тем же именем, что исходное
        $name = basename($src);
        Storage::disk('public')->put($dst . $name, $image);
        $image->destroy();
    }

    /**
     * Удаляет изображение при удалении модели
     *
     * @param \App\Models\Item $item — модель
     * @param string $dir — директория, в которой находится изображение
     */
    public function remove($item, string $dir)
    {
        $old = $item->image;
        if ($old) {
            Storage::disk('public')->delete('catalog/' . $dir . '/source/' . $old);
            Storage::disk('public')->delete('catalog/' . $dir . '/image/' . $old);
            Storage::disk('public')->delete('catalog/' . $dir . '/thumb/' . $old);
        }
    }
}

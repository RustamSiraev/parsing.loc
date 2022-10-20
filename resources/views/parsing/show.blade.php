@extends('layouts.app')

@section('content')

    <div id="report">
        <div class="search-form mb-4">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-secondary table-borderedtable-striped statistic-table" style="width:100%">
                        <tbody>
                        <tr>
                            <td>URL</td>
                            <td>{{ $parsing->href }}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>{{ date('d.m.Y H:i:s', strtotime($parsing->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>{{ sprintf('%02d:%02d:%02d', ($parsing->time() / 3600), ($parsing->time() / 60 % 60), $parsing->time() % 60) }}</td>
                        </tr>
                        <tr>
                            <td>Checked links, pcs</td>
                            <td>{{ $parsing->checked }}</td>
                        </tr>
                        <tr>
                            <td>Broken links, pcs</td>
                            <td>{{ $parsing->broken }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ $parsing->id }}" id="report-id" data-id="{{ $parsing->id }}">
        @include('part.table')
    </div>
@endsection

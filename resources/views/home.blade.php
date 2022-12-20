@extends('layouts.app')

@section('content')
    <form method="get" id="parsing-form" action="{{ route('start') }}">
        <div class="search-form mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="site">{{ __('Enter your URL') }}:</label>
                        <input id="site" type="text" class="form-control" name="site" required autocomplete="site"
                               autofocus>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <input type="checkbox" class="custom-control" id="all_pages" name="all_pages" value="1">
                <label class="custom-control-label" for="all_pages">
                    {{ __('Look for a broken link on other pages') }}
                </label>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" id="submit-button">
                    {{ __('Find broken links') }}
                </button>
            </div>
        </div>
    </form>

    <h2>{{ __('Checker history') }}</h2>
    <div class="search-form mb-4">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-secondary table-bordered table-striped reports-datatable" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Site') }}</th>
                        <th>{{ __('Time') }}</th>
                        <th>{{ __('Checked links, pcs') }}</th>
                        <th>{{ __('Broken links, pcs') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="result">
        <h2>{{ __('Checker result') }}</h2>
        <div id="result-table">
            @include('part.table')
        </div>
    </div>
@endsection

@php $level++ @endphp
@foreach($items as $item)
    <option value="{{ $item->id }}" @if ($item->id == $director_id) selected @endif>
        @if ($level) {!! str_repeat('&nbsp;&nbsp;&nbsp;', $level) !!}  @endif {{ $item->name }}
    </option>
@endforeach

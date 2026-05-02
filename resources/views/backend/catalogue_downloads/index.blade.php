@extends('layouts.app')

@section('page_title', 'Catalogue downloads')
@section('page_subtitle', 'Leads from visitors who requested a catalogue PDF on the website')

@section('content')
    @if ($downloads->isEmpty())
        <div class="adm-table-wrap">
            <p class="adm-empty mb-0">No catalogue download submissions yet.</p>
        </div>
    @else
        <div class="adm-table-wrap">
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Catalogue</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($downloads as $row)
                            <tr>
                                <td>
                                    <span class="adm-badge">
                                        {{ $loop->iteration + ($downloads->currentPage() - 1) * $downloads->perPage() }}
                                    </span>
                                </td>
                                <td><strong>{{ data_get($row, 'catalogue.name', '—') }}</strong></td>
                                <td>{{ data_get($row, 'catalogue.category.name', '—') }}</td>
                                <td>{{ $row->name }}</td>
                                <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
                                <td>{{ $row->phone ?: '—' }}</td>
                                <td>{{ $row->city ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="adm-pager">{{ $downloads->links() }}</div>
        </div>
    @endif
@endsection

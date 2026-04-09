@extends('layouts.app')

@section('page_title', 'Enquiery Entries')
@section('page_subtitle', 'Product enquiry submissions from website visitors')

@section('content')
    @if ($entries->isEmpty())
        <div class="adm-table-wrap">
            <p class="adm-empty mb-0">No enquiry entries yet.</p>
        </div>
    @else
        <div class="adm-table-wrap">
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Quantity</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr>
                                <td>
                                    <span class="adm-badge">
                                        {{ $loop->iteration + ($entries->currentPage() - 1) * $entries->perPage() }}
                                    </span>
                                </td>
                                <td>{{ $entry->product_name }}</td>
                                <td>{{ $entry->name }}</td>
                                <td>{{ $entry->phone }}</td>
                                <td>{{ $entry->quantity }}</td>
                                <td style="max-width: 22rem; white-space: normal;">{{ $entry->message ?: '—' }}</td>
                                <td>{{ optional($entry->created_at)->format('d M Y, h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="adm-pager">{{ $entries->links() }}</div>
        </div>
    @endif
@endsection

@extends('layouts.app')

@section('page_title', 'Career applications')
@section('page_subtitle', 'Submissions from the website careers form')

@section('content')
    @if ($entries->isEmpty())
        <div class="adm-table-wrap">
            <p class="adm-empty mb-0">No career applications yet.</p>
        </div>
    @else
        <div class="adm-table-wrap">
            <div class="table-responsive">
                <table class="table adm-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Experience</th>
                            <th>Education</th>
                            <th>Position</th>
                            <th>Why hire</th>
                            <th>CV</th>
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
                                <td>{{ $entry->name }}</td>
                                <td>{{ $entry->email }}</td>
                                <td>{{ $entry->phone ?: '—' }}</td>
                                <td>{{ $entry->years_experience ?: '—' }}</td>
                                <td style="max-width: 12rem; white-space: normal;">{{ $entry->education ?: '—' }}</td>
                                <td style="max-width: 12rem; white-space: normal;">{{ $entry->position ?: '—' }}</td>
                                <td style="max-width: 18rem; white-space: normal;">
                                    {{ Str::limit($entry->hire_why ?: '—', 200) }}
                                </td>
                                <td>
                                    @if ($entry->cv_path)
                                        <a href="{{ route('backend.career-applications.cv', $entry) }}" class="btn btn-sm btn-outline-primary">
                                            Download
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
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

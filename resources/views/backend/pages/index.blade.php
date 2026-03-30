@extends('layouts.app')

@section('page_title', 'Pages')
@section('page_subtitle', 'Manage your website pages')

@section('content')

<div class="adm-toolbar">
    <a href="{{ route('backend.pages.create') }}" class="adm-btn adm-btn--primary">
        <i class="bi bi-plus-lg"></i> Add Page
    </a>
</div>

@if(session('success'))
    <div class="adm-alert adm-alert--ok">{{ session('success') }}</div>
@endif

<div class="adm-table-wrap">

    @if($pages->isEmpty())
        <p class="adm-empty">No pages found. 
            <a href="{{ route('backend.pages.create') }}">Create one</a>
        </p>
    @else

    <div class="table-responsive">
        <table class="table adm-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>
                        <span class="adm-badge">
                            {{ $loop->iteration + ($pages->currentPage() - 1) * $pages->perPage() }}
                        </span>
                    </td>

                    <td><strong>{{ $page->title }}</strong></td>

                    <td>
                        <span class="text-muted">/{{ $page->slug }}</span>
                    </td>

                    <td>
                        @if($page->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>

                    <td class="text-end">
                        <div class="adm-actions justify-content-end">

                            <a href="{{ route('backend.pages.edit', $page) }}"
                                class="adm-btn adm-btn--ghost adm-btn--sm">
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="adm-pager">
        {{ $pages->links() }}
    </div>

    @endif

</div>

@endsection
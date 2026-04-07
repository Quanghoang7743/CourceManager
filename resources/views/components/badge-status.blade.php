@props(['status'])

@php
    $isPublished = $status === 'published';
@endphp

<span class="badge {{ $isPublished ? 'badge-published' : 'badge-draft' }}">
    {{ $isPublished ? 'Published' : 'Draft' }}
</span>

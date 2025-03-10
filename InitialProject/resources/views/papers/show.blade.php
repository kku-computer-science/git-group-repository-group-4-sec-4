@extends('dashboards.users.layouts.user-dash-layout')

@section('content')
<div class="container">
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">{{ __('papers.details') }}</h4>
            <p class="card-description">{{ __('papers.enter_details') }}</p>

            <div class="row">
    <p class="card-text col-sm-3"><b>{{ __('papers.paper_name') }}</b></p>
    <p class="card-text col-sm-9">
        @if(app()->getLocale() == 'zh') 
            {{ $paper->paper_name_zh ?? $paper->paper_name_en ?? $paper->paper_name }}
        @elseif(app()->getLocale() == 'en')
            {{ $paper->paper_name_en ?? $paper->paper_name }}
        @else
            {{ $paper->paper_name }}
        @endif
    </p>
</div>

<div class="row">
    <p class="card-text col-sm-3"><b>{{ __('papers.abstract') }}</b></p>
    <p class="card-text col-sm-9">
        @if(app()->getLocale() == 'zh') 
            {{ $paper->abstract_zh ?? $paper->abstract_en ?? $paper->abstract }}
        @elseif(app()->getLocale() == 'en')
            {{ $paper->abstract_en ?? $paper->abstract }}
        @else
            {{ $paper->abstract }}
        @endif
    </p>
</div>


            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.keyword') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->keyword }}</p>
            </div>

            <div class="row">
    <p class="card-text col-sm-3"><b>{{ __('papers.paper_type') }}</b></p>
    <p class="card-text col-sm-9">
        @if(app()->getLocale() == 'zh') 
            {{ $paper->paper_type_zh ?? $paper->paper_type_en ?? $paper->paper_type }}
        @elseif(app()->getLocale() == 'en')
            {{ $paper->paper_type_en ?? $paper->paper_type }}
        @else
            {{ $paper->paper_type }}
        @endif
    </p>
</div>

<div class="row">
    <p class="card-text col-sm-3"><b>{{ __('papers.paper_subtype') }}</b></p>
    <p class="card-text col-sm-9">
        @if(app()->getLocale() == 'zh') 
            {{ $paper->paper_subtype_zh ?? $paper->paper_subtype_en ?? $paper->paper_subtype }}
        @elseif(app()->getLocale() == 'en')
            {{ $paper->paper_subtype_en ?? $paper->paper_subtype }}
        @else
            {{ $paper->paper_subtype }}
        @endif
    </p>
</div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.publication') }}</b></p>
                <p class="card-text col-sm-9">
                    {{ $paper->publication ?? __('papers.no_publication_source') }}
                </p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.authors') }}</b></p>
                <p class="card-text col-sm-9">
                    @foreach($paper->author as $teacher)
                        @if($teacher->pivot->author_type == 1)
                            <b>{{ __('papers.first_author') }}:</b> {{ $teacher->author_fname }} {{ $teacher->author_lname }} <br>
                        @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                        @if($teacher->pivot->author_type == 1)
                            <b>{{ __('papers.first_author') }}:</b> {{ $teacher->fname_en }} {{ $teacher->lname_en }} <br>
                        @endif 
                    @endforeach

                    @foreach($paper->author as $teacher)
                        @if($teacher->pivot->author_type == 2)
                            <b>{{ __('papers.co_author') }}:</b> {{ $teacher->author_fname }} {{ $teacher->author_lname }} <br>
                        @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                        @if($teacher->pivot->author_type == 2)
                            <b>{{ __('papers.co_author') }}:</b> {{ $teacher->fname_en }} {{ $teacher->lname_en }} <br>
                        @endif 
                    @endforeach

                    @foreach($paper->author as $teacher)
                        @if($teacher->pivot->author_type == 3)
                            <b>{{ __('papers.corresponding_author') }}:</b> {{ $teacher->author_fname }} {{ $teacher->author_lname }} <br>
                        @endif
                    @endforeach
                    @foreach($paper->teacher as $teacher)
                        @if($teacher->pivot->author_type == 3)
                            <b>{{ __('papers.corresponding_author') }}:</b> {{ $teacher->fname_en }} {{ $teacher->lname_en }} <br>
                        @endif 
                    @endforeach
                </p>
            </div>

            <div class="row">
    <p class="card-text col-sm-3"><b>{{ __('papers.source_title') }}</b></p>
    <p class="card-text col-sm-9">
        @if(app()->getLocale() == 'zh') 
            {{ $paper->paper_sourcetitle_zh ?? $paper->paper_sourcetitle_en ?? $paper->paper_sourcetitle }}
        @elseif(app()->getLocale() == 'en')
            {{ $paper->paper_sourcetitle_en ?? $paper->paper_sourcetitle }}
        @else
            {{ $paper->paper_sourcetitle }}
        @endif
    </p>
</div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.year_published') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_yearpub }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.volume') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_volume }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.issue') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_issue }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.page_number') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_page }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.doi') }}</b></p>
                <p class="card-text col-sm-9">{{ $paper->paper_doi }}</p>
            </div>

            <div class="row mt-2">
                <p class="card-text col-sm-3"><b>{{ __('papers.url') }}</b></p>
                <a href="{{ $paper->paper_url }}" target="_blank" class="card-text col-sm-9">{{ $paper->paper_url }}</a>
            </div>

            <a class="btn btn-primary mt-5" href="{{ route('papers.index') }}">{{ __('papers.back') }}</a>
        </div>
    </div>
</div>
@endsection
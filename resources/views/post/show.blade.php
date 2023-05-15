@extends('layouts.main')

@section('title')
    {{$post->title_en}}
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-md-8">
            <div class="card p-4 ">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="card h-100">
                            <img src="{{$post->photo}}"
                                 class="card-img-top"
                                 alt="{{$post->title_en}}">
                            <div class="card-body">
                                <div class="d-flex justify-content-center my-3">
                                    <span class="badge bg-danger">
                                        <i class="fas fa-clock me-1"></i>
                                        {{$post->created_at->diffForHumans()}}
                                    </span>
                                    <span class="badge bg-success mx-2">
                                        <i class="fas fa-user me-1"></i>
                                        {{$post->admin->name}}
                                    </span>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-tag me-1"></i>
                                            {{$post->category->name_en}}
                                    </span>
                                </div>
                                <div class="card-title fw-bold">
                                    {{$post->title_en}}

                                </div>
                                <p class="card-text">
                                    {{ $post->body_en }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4 ">
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <a href="{{route('category.posts', $category)}}"
                           class="btn btn link text-decoration-none text-dark">
                            {{$category->name_en}}
                        </a>
                        <span class="badge bg-primary rounded-pill">
                            {{$category->posts()->count()}}
                            </span>
                    </li>
                @endforeach
            </ul>
        </div>

@endsection
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ $article->title ?? 'Article' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

<style>
.card-custom {border-radius: 12px; overflow: hidden; box-shadow: 0px 4px 15px rgba(0,0,0,0.1);}
.card-header {background: #007bff; color: #fff; padding: 18px; font-size: 20px;}
.preview-img {width: 100%; max-height: 320px; object-fit: cover; border-radius: 6px;}
.badge-info{font-size:13px;}
</style>

</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card card-custom">

        <div class="card-header text-center">
            {{ $article->title }}
        </div>

        <div class="card-body">
            <div class="row">
                
                <div class="col-md-8">
                    <h6 class="text-primary">Abstract</h6>
                    <p>{{ $article->abstract }}</p>

                    <h6 class="text-primary">Authors</h6>
                    <ul>
                        @foreach($article->authors as $a)
                            <li>{{ $a->author }}</li>
                        @endforeach
                    </ul>

                    @if(count($article->references) > 0)
                    <h6 class="text-primary">References</h6>
                    <ol>
                        @foreach($article->references as $ref)
                            <li>{{ $ref->reference }}</li>
                        @endforeach
                    </ol>
                    @endif
                </div>

                <div class="col-md-4 text-center">
                    @if($article->image)
                    <img src="{{ asset($article->image) }}" class="preview-img mb-3">
                    @endif

                    <a href="{{ asset($article->article) }}" target="_blank" class="btn btn-success btn-block">
                        📄 View PDF
                    </a>

                    <p class="mt-3">
                        <span class="badge badge-info">{{ $article->keyword }}</span>
                    </p>

                    <small class="text-muted">
                        Year: {{ $article->year->year ?? '-' }} <br>
                        Issue: {{ $article->issue->issues ?? '-' }} 
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>

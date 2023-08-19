@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('All Characters') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($results as $character)
                            <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $character['name'] }}</td>
                                    <td>{{ $character['status'] }}</td>
                                    <td>
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col col-md-auto">
                                                <button type="button" class="btn-sm open-modal" data-toggle="modal" data-target="#exampleModalCenter{{ $character['id'] }}" data-character="{{ json_encode($character) }}">
                                                    <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 20px;"></i>
                                                </button>
                                                <div class="modal fade bd-example-modal-lg" id="exampleModalCenter{{ $character['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>
                                            </div>
                                            <div class="col col-md-auto">
                                                <form id="favorite-form"
                                                      action="{{ $character['favorite'] ? route('user.favorite.delete') : route('user.favorite.post') }}"
                                                      method="POST">
                                                    @csrf
                                                    @if($character['favorite'])
                                                        @method('DELETE')
                                                    @endif
                                                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="ref_api" id="ref_api" value="{{ $character['id'] }}">

                                                    <button type="submit" class="btn btn-link">
                                                        @if($character['favorite'])
                                                            <i class="fa fa-star" aria-hidden="true" style="font-size: 20px; color: orange"></i>
                                                        @else
                                                            <i class="fa fa-star-o" aria-hidden="true" style="font-size: 20px;"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col col-md-auto">
                                        @if($prevPage)
                                            <a href="{{ route('home', ['page' => $prevPage]) }}" class="col">
                                                <i class="fa fa-arrow-left" aria-hidden="true" style="font-size: 20px;"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col col-md-auto">
                                        <span>{{ $page }}</span>
                                    </div>
                                    <div class="col col-md-auto">
                                        @if($nextPage)
                                            <a href="{{ route('home', ['page' => $nextPage]) }}">
                                                <i class="fa fa-arrow-right" aria-hidden="true" style="font-size: 20px;"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.open-modal').click(function () {
                console.log($(this).data('character'));
                const character = $(this).data('character')
                const modalId = $(this).data('target');
                $(modalId).html(
                    `<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col d-flex">
                                        <img src="${character.image}" alt="${character.name}" class="img-thumbnail">
                                    </div>
                                    <div class="col">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Attribute</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#</td>
                                                    <td>${character.id}</td>
                                                </tr>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>${character.name}</td>
                                                </tr>
                                                <tr>
                                                    <td>Gender</td>
                                                    <td>${character.gender}</td>
                                                </tr>
                                                <tr>
                                                    <td>Location</td>
                                                    <td>${character.location.name}</td>
                                                </tr>
                                                <tr>
                                                    <td>Origin</td>
                                                    <td>${character.origin.name}</td>
                                                </tr>
                                                <tr>
                                                    <td>Species</td>
                                                    <td>${character.species}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>${character.status}</td>
                                                </tr>
                                                <tr>
                                                    <td>Type</td>
                                                    <td>${character.type}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    `
                );
            });
        });
    </script>
@endsection


@extends('layouts.admin')
@section('content')
    @push('styles')
        <style>
            .swal-wide {
                width: 480px !important;
                max-width: 90%;
                font-size: 15px; /* taille du texte plus grande */
            }
            .swal-text-rouge {
                color: red;
            }
        </style>
    @endpush
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupons</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Tableau de bord</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Coupons</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.coupon.add') }}"><i
                            class="icon-plus"></i>Ajouter une nouveau coupon</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p id="flash-message" class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Valeur</th>
                                    <th class="text-center">Valeur du panier</th>
                                    <th class="text-center">Date d'expiration</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->id }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->type }}</td>
                                        <td>{{ $coupon->value }}</td>
                                        <td>${{ $coupon->cart_value }}</td>
                                        <td>{{ $coupon->expiry_date }}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.coupon.edit', ['id' => $coupon->id]) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="{{ route('admin.coupon.delete', ['id' => $coupon->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="item text-danger delete">
                                                        <i class="icon-trash-2"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $coupons->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form'); // let form : stocke ce formulaire.
                Swal.fire({
                    title: "Êtes-vous sûr?",
                    text: "Vous ne pourrez plus revenir en arrière !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#686868",
                    confirmButtonText: "Oui, supprimer!",
                    cancelButtonText: "Annuler",
                    customClass: {
                        popup: 'swal-wide', // clé qui cible tout le conteneur principal de la popup SweetAlert2.
                        htmlContainer: 'swal-text-rouge' // clé utilisée pour styliser le contenu de text dans une alerte SweetAlert2.
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // soumet le formulaire
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let flash = document.getElementById('flash-message');
            if(flash){
                setTimeout(function(){
                    // Animation : disparition progressive
                    flash.style.transition = 'opacity 0.5s';
                    flash.style.opacity = '0';
                    setTimeout(function(){
                        flash.style.display = 'none';
                    }, 500);
                }, 3000); // 3000ms = 3 secondes avant de disparaître
            }
        });
    </script>
@endpush

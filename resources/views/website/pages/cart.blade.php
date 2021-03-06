@extends('layouts.app')


@section('content')


    <!-- Cart Start -->
    <section id="cart" class="py-5">
        <div class="container">

            <div class="row d-flex justify-content-between">

                <div class="col-12">
                    <h2 class="fw-bold text-center text-lg-start border-start px-3">
                        Mon pannier
                    </h2>
                    <ul>
                        @foreach($errors->all() as $key => $e)
                            <li>
                                <small class="text-danger text-capitalize ">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{$e}}
                                </small>
                            </li>
                        @endforeach
                    </ul>

                </div>
                @if(session()->has('cart'))
                    <form action="{{route('cart.update')}}" method="post" id="cart-update-form">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-12">

                        <div class="table w-100">
                            <div class="table-responsive">
                                <table class="table align-middle mt-4">
                                    <thead class="bg-orange text-white">
                                    <tr>
                                        <th scope="col">Produits</th>
                                        <th class="text-center" scope="col">Quantité</th>
                                        <th class="text-center" scope="col">Montant</th>
                                        <th class="text-center" scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(session('cart')->getItems() as $key =>  $i)

                                        <tr>
                                            <td>
                                                {{$i['name']}}
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <button class="btn bg-orange text-light shadow-sm"
                                                            type="button"
                                                            onclick="let result = document.getElementById('{{$key}}');
                                                                let sst = result.value; if( !isNaN( sst )) result.value--;
                                                                document.getElementById('cart-update-form').submit();
                                                                return false;"
                                                            style="width: 40px;">
                                                        -
                                                    </button>
                                                    <input type="text" name="items[{{$key}}]"
                                                           id="{{$key}}"
                                                           value="{{$i['qty']}}"
                                                           title="Quantité:"
                                                           class="form-control py-2 text-center"
                                                           placeholder="Quantité" style="width: 20px;">
                                                    <button
                                                        onclick="let result = document.getElementById('{{$key}}');
                                                            let sst = result.value;
                                                            if( !isNaN( sst )) result.value++;
                                                            document.getElementById('cart-update-form').submit();
                                                            return false;"
                                                        class="btn bg-orange text-light shadow-sm"
                                                        type="button" style="width: 40px;">
                                                        +
                                                    </button>
                                                </div>

                                            </td>
                                            <td class="text-center">
                                                @price($i["price"] * $i["qty"]) {{config('settings.currency_code')}}
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" onclick="deleteForm({{$key}})" class="btn bg-orange text-light text-decoration-none"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="3">
                                            Frais de livraison <br>
                                            <span class="small text-muted">Voir les tarifs en bas</span>
                                        </td>
                                        <td class="text-center"><B> YALIDINE </B></td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3">
                                            Total de votre commande<br>
                                            <span class="small text-muted">Sans frais de livraison</span>
                                        </td>
                                        <td class="text-center">@price(session('cart')->getTotalPrice()) {{config('settings.currency_code')}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">

                                        </td>
                                        <td class="text-center " ><a href="{{route('cart.clear')}}" class="btn bg-orange text-white shadow-sm text-decoration-none px-5 my-3 d-block text-capitalize">Vider le panier</a></td>
                                    </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </form>
                @else
                        <div class="col-lg-12">

                            <div class="table w-100">
                                <div class="table-responsive">
                                    <table class="table align-middle mt-5">
                                        <thead class="bg-orange text-white">
                                        <tr>
                                            <th scope="col">Produits</th>
                                            <th class="text-center" scope="col">Quantité</th>
                                            <th class="text-center" scope="col">Montant</th>
                                            <th class="text-center" scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Votre panier est vide
                                            </td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div>
                    </form>

                @endif
            </div>
            @if(session()->has('cart'))
                <div class="row d-flex justify-content-between align-items-center mt-5">

                    <div class="col-12">
                        <h2 class="fw-bold text-center text-lg-start border-start px-3">
                            Informations de livraison
                        </h2>
                    </div>

                    <div class="col-lg-12">
                        @auth
                            <form action="{{route('cart.order')}}" method="POST" class="row justify-content-end mt-5" id="order-form">
                                @csrf
                            <div class="col-lg-4 mb-3">
                                <input type="text"
                                       name="name"
                                       value="{{old('name',auth()->user()->name)}}"
                                       class="form-control border-0 shadow-sm py-2 @error('name') is-invalid @enderror"
                                       placeholder="Nom et prénom">
                                @error('name')
                                    <small class="text-danger text-capitalize invalid-feedback">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-lg-4 mb-3">
                                <input type="email"
                                       name="email"
                                       value="{{old('email',auth()->user()->email)}}"
                                       class="form-control border-0 shadow-sm py-2 @error('email') is-invalid @enderror"
                                       placeholder="Adresse email">
                                @error('email')
                                    <small class="text-danger text-capitalize invalid-feedback">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-lg-4 mb-3">
                                <input type="number"
                                       name="phone"
                                       value="{{old('phone',auth()->user()->phone)}}"
                                       class="form-control border-0 shadow-sm py-2 @error('phone') is-invalid @enderror"
                                       placeholder="Numéro de téléphone">
                                @error('phone')
                                    <small class="text-danger text-capitalize invalid-feedback">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-lg-8 mb-3">
                                <input type="text"
                                       value="{{old('address',auth()->user()->address)}}"
                                       name="address"
                                       class="form-control border-0 shadow-sm py-2 @error('address') is-invalid @enderror"
                                       placeholder="Adresse de livraison">
                                @error('address')
                                    <small class="text-danger text-capitalize invalid-feedback">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{$message}}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-lg-4 mb-3">
                                <select class="form-select border-0 shadow-sm py-2 @error('city') is-invalid @enderror" name="city">
                                    <option value="constantine">Constantine</option>
                                </select>
                                @error('city') <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>

                            <div class="col-12 col-lg-auto">
                                <a href="javascript:void(0)" onclick="document.getElementById('order-form').submit()" class="btn bg-orange text-white shadow-sm text-decoration-none px-5 mt-3 d-block text-capitalize">
                                    Valider ma commande
                                </a>
                            </div>

                        </form>
                        @else
                            <div class="alert alert-warning border-0 shadow-sm mt-4 py-4" role="alert">
                                <i class="fas fa-info-circle me-2"></i>Vous devez vous <a href="{{route('login')}}" class="text-primary">connecter</a> pour continuer
                            </div>
                        @endif
                    </div>

                </div>
            @endif
        </div>
    </section>
    <!-- Cart End -->

@endsection

@push('js')

    <script>
        const deleteForm = id => {
            createForm(id).submit();
        }
        const createForm = id => {
            let f = document.createElement("form");
            f.setAttribute('method',"post");
            f.setAttribute('action',`/cart/removeItem/${id}`);

            let i1 = document.createElement("input"); //input element, text
            i1.setAttribute('type',"hidden");
            i1.setAttribute('name','_token');
            i1.setAttribute('value','{{csrf_token()}}');

            let i2 = document.createElement("input"); //input element, text
            i2.setAttribute('type',"hidden");
            i2.setAttribute('name','_method');
            i2.setAttribute('value','DELETE');

            f.appendChild(i1);
            f.appendChild(i2);
            document.body.appendChild(f);
            return f;
        }
    </script>

@endpush

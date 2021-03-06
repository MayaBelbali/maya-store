<div class="{{request()->is(['shop']) ? 'col-lg-4  mt-5' : 'col-lg-3 mb-4'}}">

    <div class="card product border-0">

        <div class=" meme_hauteur" style="aspect-ratio: 16 / 9; background: url('{{$p->image_url}}'); background-repeat: no-repeat; background-position: center; background-size: cover">
            @if($p->discount)
                <span class="badge bg-orange rounded-2 product-discount">- {{$p->discount}}%</span>
            @endif
        </div>
        <br><br>
        <div class="content">

            <a href="javascript:void(0)" onclick="document.getElementById('form-card-add-{{$p->id}}').submit()"  class="btn bg-white text-orange rounded-0 text-capitalize w-25 py-3 rounded-2 shadow-sm">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="{{$p->path()}}" class="btn bg-white text-orange rounded-0 text-capitalize w-25 py-3 rounded-2 shadow-sm">
                <i class="fas fa-eye"></i>
            </a>

        </div>

    </div>
    <br>

    <div class="px-3 product-infos">

        <div class="product-title">
            <p class="mb-0 mt-4 text-truncate">
                <a href="{{$p->path()}}" class="text-decoration-none text-black" title="{{$p->name}}">{{$p->name}}</a>
            </p>
        </div>

        <div class="product-price mt-2">
            <span class="me-2 text-orange fw-bold">@price($p->price)  {{config('settings.currency_code')}}</span>
            @if($p->old_price)
                <span class="text-muted text-decoration-line-through ms-1">@price($p->old_price) {{config('settings.currency_code')}}</span>
            @endif
        </div>

    </div>


    <form action="{{route('cart.store',$p->id)}}" method="post" id="form-card-add-{{$p->id}}"> @csrf
        <input type="hidden" name="qty" value="1">
    </form>
</div>


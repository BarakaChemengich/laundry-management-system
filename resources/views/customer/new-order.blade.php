@extends('layouts.app')

@section('content')

<div class="booking-wrapper">

<div class="booking-container">

    <!-- Header -->
    <div class="booking-header">

    <div class="header-left">

        <div class="header-icon">
            🧺
        </div>

        <div>

            <small>BOOK LAUNDRY SERVICE</small>

            <h2>{{ $package->name }}</h2>

            <p>Choose your preferred laundry store</p>

        </div>

    </div>

    <div class="steps">

        <span class="active">1</span>

        <span>2</span>

        <span>3</span>

        <span>4</span>

    </div>

</div>
    <div class="booking-body">

        <!-- LEFT SIDE -->
        <div class="stores">

            <div class="top-row">
                <h3>Choose Laundry Store</h3>

                <select id="storeSearch" class="store-search">

    <option value="">Choose a Laundry Store</option>

    <option value="CleanWave Laundry">
        CleanWave Laundry
    </option>

    <option value="FreshFold Laundry">
        FreshFold Laundry
    </option>

    <option value="Sparkle Laundry">
        Sparkle Laundry
    </option>

    <option value="Aqua Wash">
        Aqua Wash
    </option>

</select>
            </div>

            <!-- Store -->
            <div class="store-card">

                <div class="store-top">

                    <span class="badge">
                        SHOP STORE
                    </span>

                    <span class="verified">
                        ✓ Verified
                    </span>

                </div>

                <h4>CleanWave Laundry</h4>

                <p>Commercial Street, Nairobi</p>

                <div class="store-info">

                    <span>⭐ 4.8</span>

                    <span>📍 0.8 km</span>

                    <span>💰 KSh120/kg</span>

                </div>

<button
class="select-store"
data-id="1"
data-name="CleanWave Laundry"
data-price="120">
Select Store
</button>
            </div>

            <!-- Store -->

            <div class="store-card">

                <div class="store-top">

                    <span class="badge">
                        SHOP STORE
                    </span>

                    <span class="verified">
                        ✓ Verified
                    </span>

                </div>

                <h4>FreshFold Laundry</h4>

                <p>Ngong Road, Nairobi</p>

                <div class="store-info">

                    <span>⭐ 4.6</span>

                    <span>📍 1.2 km</span>

                    <span>💰 KSh110/kg</span>

                </div>

                <button
class="select-store"
data-id="2"
data-name="FreshFold Laundry"
data-price="110">
Select Store
</button>
            </div>

        </div>

        <!-- RIGHT SIDE -->

        <!-- RIGHT SIDE -->

<div class="summary">

    <h3>ORDER SUMMARY</h3>
     <div class="summary-item">
    <span>Selected Store</span>
    <strong id="selectedStore">
 : No store selected
</strong>
</div>

<hr>

    <div class="summary-item">
        <span>Service</span>
<strong id="unitPrice">
KSh 0/Per Kg
</strong>    </div>

    <div class="summary-item">
        <span>Unit Price</span>
        <strong>KSh {{ $package->price_per_unit }}/{{ $package->pricing_type }}</strong>
    </div>

    <hr>

    <form action="{{ route('customer.place-order') }}" method="POST">

@csrf

<input
type="hidden"
name="vendor_id"
id="vendor_id">

<input
type="hidden"
name="laundry_package_id"
value="{{ $package->id }}">
        
        <button
type="submit"
class="continue-btn">

Place Order

</button>
 <a
href="{{ route('customer.dashboard') }}"
class="cancel-btn">

Cancel Order

</a>
       

    </form>

</div>
    </div>

</div> <!-- booking-container -->
</div> <!-- booking-wrapper -->

<script>

const buttons = document.querySelectorAll(".select-store");

buttons.forEach(button => {

    button.addEventListener("click", function () {

        document.getElementById("vendor_id").value =
            this.dataset.id;

        document.getElementById("selectedStore").innerText =
            this.dataset.name;

        buttons.forEach(btn => {

            btn.innerHTML = "Select Store";

            btn.style.background = "";

        });

        this.innerHTML = "✔ Selected";

        this.style.background = "#22c55e";

    });

});

</script>
<script>

const search = document.getElementById('storeSearch');

search.addEventListener('change',function(){

    const store=this.value;

    document.querySelectorAll('.store-card').forEach(card=>{

        if(card.querySelector('h4').innerText===store){

            card.scrollIntoView({
                behavior:'smooth',
                block:'center'
            });

            card.style.border='2px solid #2563eb';

        }else{

            card.style.border='1px solid #eee';

        }

    });

});

</script>
<script>

document.querySelectorAll(".select-store").forEach(button=>{

button.addEventListener("click",function(){

document.getElementById("selectedStore").innerHTML=this.dataset.name;

document.getElementById("unitPrice").innerHTML=
"KSh "+this.dataset.price+"/Per Kg";

document.getElementById("vendor_id").value=this.dataset.id;

});

});

</script>
@endsection
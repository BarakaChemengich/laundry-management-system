@extends('layouts.app')

@section('content')

<div class="booking-wrapper">

    <div class="booking-container">

        <!-- ================= HEADER ================= -->
        <div class="booking-header">

            <div class="header-left">

                <div class="header-icon">🧺</div>

                <div>

                    <small>BOOK LAUNDRY SERVICE</small>

                    <h2>{{ $order->laundryPackage->name }}</h2>

                    <p>Specify Service & Clothes</p>

                </div>

            </div>

            <div class="steps">
                <span class="completed">✓</span>
                <span class="active">2</span>
                <span>3</span>
                <span>4</span>
            </div>

        </div>

        <form method="POST"
              action="{{ route('customer.save-service',$order->id) }}">

            @csrf

            <!-- Hidden Inputs -->
            <input type="hidden"
                   name="service_type"
                   id="serviceInput"
                   value="Wash & Fold">

            <input type="hidden"
                   name="weight_quantity"
                   id="weightInput"
                   value="5">

            <input type="hidden"
                   name="total_price"
                   id="totalInput"
                   value="600">

            <input type="hidden"
                   name="special_instructions"
                   id="instructionInput">

            <div class="booking-content">

                <!-- ================================================= -->
                <!-- LEFT SIDE -->
                <!-- ================================================= -->

                <div class="services-section">

                    <div class="section-header">

                        <h3>Specify Service & Clothes</h3>

                        <span>Step 2 of 4</span>

                    </div>

                    <div class="services-grid">

                        <div class="service-card active"
                             data-service="Wash & Fold"
                             data-price="120">

                            <div class="service-icon">🧺</div>

                            <h4>Wash & Fold</h4>

                            <small>KSh 120/kg</small>

                        </div>

                        <div class="service-card"
                             data-service="Dry Cleaning"
                             data-price="250">

                            <div class="service-icon">👔</div>

                            <h4>Dry Cleaning</h4>

                            <small>KSh 250/item</small>

                        </div>

                        <div class="service-card"
                             data-service="Ironing"
                             data-price="60">

                            <div class="service-icon">👕</div>

                            <h4>Ironing</h4>

                            <small>KSh 60/item</small>

                        </div>

                        <div class="service-card"
                             data-service="Bedding"
                             data-price="300">

                            <div class="service-icon">🛏️</div>

                            <h4>Bedding</h4>

                            <small>KSh 300/item</small>

                        </div>

                        <div class="service-card"
                             data-service="Curtains"
                             data-price="400">

                            <div class="service-icon">🪟</div>

                            <h4>Curtains</h4>

                            <small>KSh 400/item</small>

                        </div>

                        <div class="service-card"
                             data-service="Shoes"
                             data-price="350">

                            <div class="service-icon">👟</div>

                            <h4>Shoes</h4>

                            <small>KSh 350/pair</small>

                        </div>

                    </div>

                    <!-- Weight -->

                    <div class="details-card">

                        <h4>Detailed Sizing & Settings</h4>

                        <div class="weight-header">

                            <span>Approximate Weight</span>

                            <strong id="weightValue">5 Kg</strong>

                        </div>

                        <input
                            type="range"
                            id="weightSlider"
                            min="1"
                            max="30"
                            value="5">

                        <div class="weight-labels">

                            <small>1 Kg</small>

                            <small>30 Kg</small>

                        </div>

                        <div class="instructions">

                            <label>Special Instructions</label>

                            <textarea
                                id="instructions"
                                placeholder="Separate white clothes..."></textarea>

                        </div>

                    </div>

                </div>

                <!-- ================================================= -->
                <!-- RIGHT SIDE -->
                <!-- ================================================= -->

                <div class="summary-section">

                    <h3>INVOICE SUMMARY</h3>

                    <div class="summary-row">
                        <span>Provider</span>
                        <strong>{{ $order->vendor->name }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Service</span>
                        <strong id="selectedService">
                            Wash & Fold
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Quantity</span>
                        <strong id="quantity">
                            5 Kg
                        </strong>
                    </div>

                    <div class="summary-row">
                        <span>Unit Price</span>
                        <strong id="unitPrice">
                            KSh 120
                        </strong>
                    </div>

                    <hr>

                    <div class="summary-row total">

                        <span>Grand Total</span>

                        <strong id="grandTotal">
                            KSh 600
                        </strong>

                    </div>

                    <button
                        type="submit"
                        class="continue-btn">

                        Continue to Step 3 →

                    </button>

                    <button
                        type="button"
                        class="cancel-btn"
                        onclick="history.back()">

                        Cancel Order

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

const cards=document.querySelectorAll(".service-card");

const serviceName=document.getElementById("selectedService");
const unitPrice=document.getElementById("unitPrice");
const quantity=document.getElementById("quantity");
const grandTotal=document.getElementById("grandTotal");

const weightSlider=document.getElementById("weightSlider");
const weightValue=document.getElementById("weightValue");

const serviceInput=document.getElementById("serviceInput");
const weightInput=document.getElementById("weightInput");
const totalInput=document.getElementById("totalInput");

const textarea=document.getElementById("instructions");
const instructionInput=document.getElementById("instructionInput");

let selectedPrice=120;

function calculateTotal(){

    let weight=parseInt(weightSlider.value);

    weightValue.innerHTML=weight+" Kg";

    quantity.innerHTML=weight+" Kg";

    let total=selectedPrice*weight;

    grandTotal.innerHTML="KSh "+total;

    weightInput.value=weight;

    totalInput.value=total;

}

cards.forEach(card=>{

    card.addEventListener("click",function(){

        cards.forEach(c=>c.classList.remove("active"));

        this.classList.add("active");

        serviceName.innerHTML=this.dataset.service;

        serviceInput.value=this.dataset.service;

        selectedPrice=parseInt(this.dataset.price);

        unitPrice.innerHTML="KSh "+selectedPrice;

        calculateTotal();

    });

});

weightSlider.addEventListener("input",calculateTotal);

textarea.addEventListener("keyup",function(){

    instructionInput.value=this.value;

});

calculateTotal();

</script>

@endsection
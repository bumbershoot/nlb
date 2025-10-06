@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fab fa-cc-stripe me-2"></i>Stripe Payment</h4>
                </div>
                <div class="card-body">
                    <!-- Payment Summary -->
                    <div class="alert alert-info">
                        <h6>Payment Summary</h6>
                        <p class="mb-1"><strong>Booking:</strong> #{{ $payment->booking->id }}</p>
                        <p class="mb-1"><strong>Cabana:</strong> {{ $payment->booking->cabana->name }}</p>
                        <p class="mb-0"><strong>Amount:</strong> RM {{ number_format($payment->amount, 2) }}</p>
                    </div>

                    <!-- Stripe Payment Form -->
                    <form id="payment-form">
                        <div id="payment-element">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        <div class="text-center mt-4">
                            <button id="submit" class="btn btn-primary btn-lg px-5">
                                <div class="spinner d-none" id="spinner"></div>
                                <span id="button-text">Pay RM {{ number_format($payment->amount, 2) }}</span>
                            </button>
                        </div>
                        <div id="payment-message" class="d-none mt-3"></div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('bookings.show', $payment->booking->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
// Initialize Stripe
const stripe = Stripe('{{ config("services.stripe.key") }}');

let elements;

initialize();
checkStatus();

document
    .querySelector("#payment-form")
    .addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {
    const { error } = await stripe.createPaymentMethod({
        type: 'card',
    });

    elements = stripe.elements({ 
        clientSecret: '{{ $payment->gateway_payment_intent_id ? $payment->gateway_response["client_secret"] ?? "" : "" }}'
    });

    const paymentElementOptions = {
        layout: "tabs",
    };

    const paymentElement = elements.create("payment", paymentElementOptions);
    paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Make sure to change this to your payment completion page
            return_url: "{{ route('payments.stripe.confirm', $payment->id) }}",
        },
    });

    if (error.type === "card_error" || error.type === "validation_error") {
        showMessage(error.message);
    } else {
        showMessage("An unexpected error occurred.");
    }

    setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );

    if (!clientSecret) {
        return;
    }

    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

    switch (paymentIntent.status) {
        case "succeeded":
            showMessage("Payment succeeded!");
            break;
        case "processing":
            showMessage("Your payment is processing.");
            break;
        case "requires_payment_method":
            showMessage("Your payment was not successful, please try again.");
            break;
        default:
            showMessage("Something went wrong.");
            break;
    }
}

// ------- UI helpers -------
function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("d-none");
    messageContainer.textContent = messageText;

    setTimeout(function () {
        messageContainer.classList.add("d-none");
        messageContainer.textContent = "";
    }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("d-none");
        document.querySelector("#button-text").classList.add("d-none");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("d-none");
        document.querySelector("#button-text").classList.remove("d-none");
    }
}
</script>

<style>
.spinner {
    border: 2px solid #f3f3f3;
    border-radius: 50%;
    border-top: 2px solid #3498db;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#payment-message {
    color: rgb(105, 115, 134);
    font-size: 16px;
    line-height: 20px;
    padding-top: 12px;
    text-align: center;
}
</style>
@endsection

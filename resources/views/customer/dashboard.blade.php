@extends('layouts.app')

@section('content')

<div class="dashboard-content">

    <!-- Greeting Section -->
    <div class="greeting-section">
        <h1>Hi, {{ auth()->user()->name }} 👋</h1>
        <p>What would you like cleaned today?</p>
    </div>

    <!-- Services Section -->
    <div class="services-container">
        <div class="service-card" onclick="selectService('Wash & Fold', 120)">
            <div class="service-icon">🧺</div>
            <p>Wash & Fold</p>
        </div>

        <div class="service-card" onclick="selectService('Dry Cleaning', 250)">
            <div class="service-icon">👕</div>
            <p>Dry Cleaning</p>
        </div>

        <div class="service-card" onclick="selectService('Ironing', 80)">
            <div class="service-icon">🧼</div>
            <p>Ironing</p>
        </div>

        <div class="service-card" onclick="selectService('Bedding', 150)">
            <div class="service-icon">🛏️</div>
            <p>Bedding</p>
        </div>

        <div class="service-card" onclick="selectService('Curtains', 200)">
            <div class="service-icon">🪟</div>
            <p>Curtains</p>
        </div>

        <div class="service-card" onclick="selectService('Shoes', 300)">
            <div class="service-icon">👟</div>
            <p>Shoes</p>
        </div>

        <div class="service-card" onclick="switchView('new-order')">
            <div class="service-icon">➕</div>
            <p>More</p>
        </div>
    </div>

    <!-- Promotional Cards -->
    <div class="promo-container">
        <!-- First Order -->
        <div class="promo-card blue">
            <span class="promo-tag">20% OFF</span>
            <h3>Your First Order</h3>
            <p>Use code: <strong>WELCOME20</strong></p>
            <button onclick="switchView('new-order')">Order Now</button>
        </div>

        <!-- Free Pickup -->
        <div class="promo-card green">
            <span class="promo-tag">FREE DELIVERY</span>
            <h3>Free Pickup & Return</h3>
            <p>On all orders above KSh 1,000</p>
            <small>📍 Nairobi | Serviced</small>
        </div>

        <!-- Bundle Deals -->
        <div class="promo-card dark">
            <span class="promo-tag">HOT BUNDLES</span>
            <h3>Laundry Bundle Deals</h3>
            <p>More items, more savings!</p>
            <button onclick="switchView('new-order')">Explore Deals</button>
        </div>
    </div>

    <!-- Nearby Laundromats -->
    <div class="section-header">
        <h2>Laundromats Near You</h2>
        <a href="#">See all</a>
    </div>

    <div class="laundromat-container">
        <!-- Card 1 -->
        <div class="laundromat-card">
            <div class="laundromat-logo logo-cl">CL</div>
            <div class="laundromat-info">
                <h3>CleanWave Laundry</h3>
                <div class="rating">⭐ 4.8</div>
                <p>📍 0.8 km away</p>
                <p>⏰ 30 - 48 hrs</p>
                <p><strong>KSh 120/kg</strong></p>
                <button>View Services</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="laundromat-card">
            <div class="laundromat-logo logo-fr">FR</div>
            <div class="laundromat-info">
                <h3>FreshFold Laundry</h3>
                <div class="rating">⭐ 4.6</div>
                <p>📍 1.2 km away</p>
                <p>⏰ 24 - 48 hrs</p>
                <p><strong>KSh 110/kg</strong></p>
                <button>View Services</button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="laundromat-card">
            <div class="laundromat-logo logo-sp">SP</div>
            <div class="laundromat-info">
                <h3>Sparkle Laundry</h3>
                <div class="rating">⭐ 4.7</div>
                <p>📍 1.8 km away</p>
                <p>⏰ 24 - 48 hrs</p>
                <p><strong>KSh 115/kg</strong></p>
                <button>View Services</button>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="laundromat-card">
            <div class="laundromat-logo logo-aq">AQ</div>
            <div class="laundromat-info">
                <h3>Aqua Wash</h3>
                <div class="rating">⭐ 4.5</div>
                <p>📍 2.3 km away</p>
                <p>⏰ 48 - 72 hrs</p>
                <p><strong>KSh 125/kg</strong></p>
                <button>View Services</button>
            </div>
        </div>
    </div>

    <!-- Dashboard Bottom -->
    <div class="dashboard-bottom">
        <!-- Most Loved -->
        <div class="most-loved">
            <div class="section-header">
                <h2>Most Loved Laundromats</h2>
                <a href="#">See all</a>
            </div>

            <div class="loved-list">
                <div class="loved-card">
                    <div class="circle blue">CL</div>
                    <h4>CleanWave</h4>
                    <small>⭐ 4.8</small>
                </div>

                <div class="loved-card">
                    <div class="circle green">FR</div>
                    <h4>FreshFold</h4>
                    <small>⭐ 4.6</small>
                </div>

                <div class="loved-card">
                    <div class="circle purple">SP</div>
                    <h4>Sparkle</h4>
                    <small>⭐ 4.7</small>
                </div>

                <div class="loved-card">
                    <div class="circle cyan">AQ</div>
                    <h4>Aqua Wash</h4>
                    <small>⭐ 4.5</small>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="recent-orders-wrapper">
            <div class="section-header">
                <h2>Recent Orders</h2>
                <a href="#">See all</a>
            </div>

            <div class="recent-orders">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>#LAU-{{ $order->id }}</td>
                                <td>{{ $order->service_type ?? 'Wash & Fold' }}</td>
                                <td>
                                    <span class="status 
                                        {{ $order->status === 'DELIVERED' ? 'completed' : 
                                           ($order->status === 'PENDING' ? 'pending' : 'progress') }}">
                                        {{ str_replace('_', ' ', $order->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td>KSh {{ number_format($order->total_price ?? 0, 2) }}</td>
                                <td>{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #94A3B8;">
                                    No recent orders yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
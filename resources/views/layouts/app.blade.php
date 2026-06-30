<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MowingWash</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* =============================================
           NAVBAR & SIDEBAR STYLES
           ============================================= */

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue:        #2563EB;
            --blue-dark:   #1D4ED8;
            --blue-light:  #EEF4FF;
            --green:       #0f9d58;
            --dark:        #131b38;
            --yellow:      #FFD54F;
            --orange:      #F97316;
            --bg:          #F5F7FB;
            --white:       #FFFFFF;
            --text:        #14213D;
            --muted:       #7A869A;
            --light:       #94A3B8;
            --border:      #EDF2F7;
            --star:        #F4B400;
            --sidebar-w:   190px;
            --topbar-h:    72px;
            --radius-sm:   8px;
            --radius-md:   14px;
            --radius-lg:   20px;
            --radius-full: 9999px;
            --shadow:      0 2px 12px rgba(0,0,0,0.07);
        }

        body {
            font-family: 'Poppins', 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.5;
        }

        a { text-decoration: none; color: inherit; }
        ul, ol { list-style: none; }
        button { cursor: pointer; font-family: inherit; }

        /* =============================================
           LAYOUT
           ============================================= */

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: var(--sidebar-w);
            min-width: 0;
        }

        .content {
            flex: 1;
            padding: 0;
            overflow-y: auto;
            background: var(--bg);
        }

        /* =============================================
           SIDEBAR
           ============================================= */

        .sidebar {
            width: var(--sidebar-w);
            background: var(--white);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 18px 18px;
            border-bottom: 1px solid var(--border);
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: var(--blue);
            color: #fff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
            font-size: 16px;
            flex-shrink: 0;
        }

        .logo-text h2 {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 9px;
            color: var(--light);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .menu {
            padding: 10px 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .menu li a,
        .menu li button.logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 500;
            color: var(--muted);
            transition: background 0.15s, color 0.15s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
        }

        .menu li a i,
        .menu li button.logout-btn i {
            width: 16px;
            font-size: 14px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu li a:hover {
            background: var(--bg);
            color: var(--blue);
        }

        .menu li.active a {
            background: var(--blue-light);
            color: var(--blue);
            font-weight: 600;
        }

        .menu li a .nav-badge {
            margin-left: auto;
            background: var(--blue);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .menu-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 0;
        }

        .logout {
            padding: 0 10px 16px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 600;
            color: #EF4444;
            background: none;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .logout-btn i {
            width: 16px;
            text-align: center;
        }

        .logout-btn:hover {
            background: #FEF2F2;
        }

        .refer-card {
            margin: 8px 10px 4px;
            padding: 14px;
            background: var(--blue-light);
            border-radius: var(--radius-md);
        }

        .refer-card h3 {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .refer-card p {
            font-size: 11px;
            color: var(--muted);
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .refer-card button {
            width: 100%;
            padding: 9px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            border-radius: var(--radius-sm);
            background: var(--blue);
            color: #fff;
            cursor: pointer;
            transition: background 0.15s;
        }

        .refer-card button:hover {
            background: var(--blue-dark);
        }

        /* =============================================
           NAVBAR
           ============================================= */

        .navbar {
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .location {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .location i.fa-location-dot {
            color: var(--blue);
            font-size: 17px;
        }

        .location small {
            display: block;
            font-size: 10px;
            color: var(--light);
            font-weight: 400;
        }

        .location strong {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .location strong i {
            font-size: 11px;
            color: var(--muted);
        }

        .search-box {
            display: flex;
            align-items: center;
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 0 16px 0 14px;
            border-radius: var(--radius-full);
            height: 38px;
            flex: 1;
            max-width: 400px;
            gap: 8px;
            transition: border-color 0.15s;
        }

        .search-box:focus-within {
            border-color: var(--blue);
            background: var(--white);
        }

        .search-box i {
            color: var(--light);
            font-size: 13px;
            flex-shrink: 0;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 13px;
            font-family: inherit;
            color: var(--text);
        }

        .search-box input::placeholder {
            color: var(--light);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .nav-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            border: 1px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 15px;
            cursor: pointer;
            position: relative;
            transition: border-color 0.15s, color 0.15s;
        }

        .nav-icon-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .nav-icon-btn .notif-dot {
            position: absolute;
            top: 7px;
            right: 8px;
            width: 6px;
            height: 6px;
            background: var(--blue);
            border-radius: var(--radius-full);
            border: 1.5px solid white;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            margin-left: 4px;
        }

        .profile img {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 2px solid var(--border);
        }

        .profile small {
            display: block;
            font-size: 9.5px;
            color: var(--light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 500;
        }

        .profile strong {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
        }

        /* =============================================
           DASHBOARD CONTENT
           ============================================= */

        .dashboard-content {
            padding: 28px 36px;
        }

        .greeting-section {
            margin-bottom: 22px;
        }

        .greeting-section h1 {
            font-size: 21px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .greeting-section p {
            font-size: 13.5px;
            color: var(--muted);
        }

        .services-container {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 4px;
            overflow-x: auto;
            margin-top: 0;
            margin-bottom: 22px;
            box-shadow: none;
            scrollbar-width: none;
        }

        .services-container::-webkit-scrollbar { display: none; }

        .service-card {
            flex: 0 0 auto;
            text-align: center;
            cursor: pointer;
            padding: 10px 16px;
            border-radius: var(--radius-md);
            transition: background 0.15s, transform 0.15s;
        }

        .service-card:hover {
            background: var(--bg);
            transform: translateY(-3px);
        }

        .service-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 10px;
            border-radius: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 26px;
            background: var(--bg);
            border: 1px solid var(--border);
        }

        .service-card p {
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text);
            white-space: nowrap;
        }

        .promo-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 0;
            margin-bottom: 28px;
        }

        .promo-card {
            flex: unset;
            padding: 22px 22px 20px;
            border-radius: var(--radius-lg);
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 155px;
            display: flex;
            flex-direction: column;
        }

        .promo-tag {
            background: var(--yellow);
            color: #5a3e00;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 10.5px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 12px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            width: fit-content;
        }

        .promo-card h3 {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .promo-card p {
            font-size: 11.5px;
            opacity: 0.9;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .promo-card small {
            font-size: 11.5px;
            opacity: 0.85;
            margin-top: 2px;
        }

        .promo-card button {
            margin-top: auto;
            padding-top: 14px;
            border: none;
            background: white;
            color: var(--blue);
            padding: 9px 20px;
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 12.5px;
            cursor: pointer;
            transition: opacity 0.15s;
            width: fit-content;
            font-family: inherit;
        }

        .promo-card button:hover { opacity: 0.88; }

        .dark button {
            color: var(--dark);
        }

        .blue  { background: #2563EB; }
        .green { background: #0f9d58; }
        .dark  { background: #131b38; }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin: 0 0 16px;
        }

        .section-header h2 {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 2px;
        }

        .section-header p {
            font-size: 12px;
            color: var(--muted);
        }

        .section-header a {
            font-size: 13px;
            font-weight: 600;
            color: var(--blue);
            display: flex;
            align-items: center;
            gap: 3px;
            white-space: nowrap;
        }

        .section-header a:hover { text-decoration: underline; }

        .laundromat-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 32px;
        }

        .laundromat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            box-shadow: var(--shadow);
            transition: box-shadow 0.15s, transform 0.15s;
        }

        .laundromat-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.10);
            transform: translateY(-3px);
        }

        .laundromat-logo {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        .logo-cl { background: #0EA5E9; }
        .logo-fr { background: #10B981; }
        .logo-sp { background: #A855F7; }
        .logo-aq { background: #F59E0B; }

        .rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
        }

        .laundromat-info h3 {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0;
        }

        .laundromat-info p {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
            font-size: 12px;
            margin: 3px 0;
        }

        .laundromat-info p i {
            width: 14px;
            text-align: center;
            font-size: 12px;
        }

        .laundromat-info button {
            margin-top: 10px;
            width: 100%;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text);
            padding: 9px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 12.5px;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
            font-family: inherit;
        }

        .laundromat-info button:hover {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
        }

        .dashboard-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 0;
        }

        .most-loved {
            background: var(--white);
            border: 1px solid var(--border);
            padding: 20px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .loved-list {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 18px;
        }

        .loved-card {
            text-align: center;
            flex: 1;
        }

        .circle {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-full);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: 700;
            font-size: 13px;
            margin: 0 auto 8px;
        }

        .circle.blue { background: #2563EB; }
        .circle.green { background: #0f9d58; }
        .circle.purple { background: #A855F7; }
        .circle.cyan { background: #06B6D4; }

        .loved-card p {
            font-size: 11px;
            font-weight: 600;
            color: var(--text);
        }

        .loved-card small {
            font-size: 10px;
            color: var(--muted);
        }

        .recent-orders-wrapper {
            display: flex;
            flex-direction: column;
        }

        .recent-orders {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow);
            overflow-x: auto;
        }

        .recent-orders table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-orders th {
            text-align: left;
            padding: 10px 12px;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .recent-orders td {
            padding: 13px 12px;
            border-bottom: 1px solid #f8f8f8;
            font-size: 12.5px;
            color: var(--text);
        }

        .recent-orders tr:last-child td { border-bottom: none; }

        .status {
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .pending   { background: #FEF3C7; color: #92400E; }
        .progress  { background: #DBEAFE; color: #1D4ED8; }
        .completed { background: #DCFCE7; color: #15803D; }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: var(--radius-full); }

        @media (max-width: 1200px) {
            .laundromat-container { grid-template-columns: repeat(2, 1fr); }
            .promo-container      { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 900px) {
            .sidebar { width: 64px; }
            .logo-text, .menu li a span, .menu li a .nav-wallet,
            .refer-card { display: none; }
            .menu li a { justify-content: center; padding: 12px; }
            .menu li a i { width: auto; }
            .main-content { margin-left: 64px; }
            .dashboard-content { padding: 20px 18px; }
            .dashboard-bottom { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .promo-container      { grid-template-columns: 1fr; }
            .laundromat-container { grid-template-columns: 1fr; }
            .profile strong, .profile small { display: none; }
        }
        <style>

<style>

.booking-container{

    max-width:1100px;
    margin:auto;
    padding:30px;

}

.booking-header{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:28px 40px;   /* reduced */
    min-height:140px;    /* reduced */

    background:#3563E9;
    border-radius:22px 22px 0 0;
}

.booking-header h2{

    margin:10px 0;

}

.steps{

    display:flex;

    gap:15px;

}

.steps span{

    width:40px;

    height:40px;

    border-radius:50%;

    background:#3B82F6;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

}

.steps .active{

    background:#FACC15;

    color:black;

}

.booking-body{
    display:flex;
    gap:25px;
    padding:25px;
}

.top-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;

}

.top-row input{

    width:280px;

    padding:12px;

    border:1px solid #ddd;

    border-radius:8px;

}
.stores{
    flex:2;
    padding:20px;
}
.store-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:18px;
    padding:20px;
    margin:18px 0;
}

.store-card:hover{

    border-color:#2563EB;

}

.store-top{

    display:flex;

    justify-content:space-between;

}

.badge{

    background:#DBEAFE;

    color:#2563EB;

    padding:5px 12px;

    border-radius:20px;

    font-size:12px;

}

.verified{

    color:green;

    font-size:14px;

}

.store-info{

    display:flex;

    gap:25px;

    margin:20px 0;

}

.store-card button{

    width:100%;

    padding:12px;

    border:none;

    border-radius:8px;

    background:#2563EB;

    color:white;

    cursor:pointer;

}

.summary{

    background:white;

    border-radius:15px;

    padding:25px;

    box-shadow:0 5px 20px rgba(0,0,0,.08);

    height:fit-content;

}

.summary-item{

    display:flex;

    justify-content:space-between;

    margin:18px 0;

}

.total{

    font-size:20px;

}

.continue-btn{

    width:100%;

    margin-top:20px;

    padding:15px;

    border:none;

    border-radius:10px;

    background:#2563EB;

    color:white;

    font-size:16px;

}
.booking-wrapper{
    display:flex;
    justify-content:center;
    padding:40px 20px;
}
.booking-container{

    width:90%;
    max-width:1100px;

    background:#fff;

    border-radius:18px;

    overflow:hidden;

    box-shadow:0 10px 30px rgba(0,0,0,.08);

}
.booking-header{

    background:#2F5BEA;

    color:#fff;

    padding:30px 40px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}
.header-left{

    display:flex;

    align-items:center;

    gap:18px;

}
.header-icon{

    width:65px;

    height:65px;

    border-radius:50%;

    background:rgba(255,255,255,.15);

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:32px;

}
.steps{

    display:flex;

    gap:18px;

}
.steps span{

    width:38px;

    height:38px;

    border-radius:50%;

    background:rgba(255,255,255,.25);

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:bold;

}
.steps .active{

    background:#FFC107;

    color:#000;

}
.store-search{
    width:320px;
    padding:12px 18px;
    border:1px solid #d6dce5;
    border-radius:12px;
    font-size:15px;
    background:#fff;
    outline:none;
    transition:.3s;
}

.store-search:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.15);
}
.cancel-btn{
display:block;
text-align:center;
background:#f3f4f6;
padding:15px;
border-radius:12px;
text-decoration:none;
font-weight:600;
color:#111827;
margin-top:15px;
transition:.3s;
}

.cancel-btn:hover{
background:#e5e7eb;
}
.booking-wrapper{
    padding:40px;
    background:#f5f7fb;
}

.booking-container{
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
    
}

.booking-header{
    background:#2f5bea;
    color:white;
    padding:35px 45px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header-left{
    display:flex;
    align-items:center;
    gap:18px;
}

.header-icon{
    width:60px;
    height:60px;
    border-radius:18px;
    background:rgba(255,255,255,.15);

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:30px;
}

.header-left small{
    color:#FFD54A;
    font-weight:700;
    letter-spacing:2px;
    font-size:13px;
}

.header-left h2{
    margin:5px 0;
    font-size:34px;
    font-weight:600;
}

.header-left p{
    opacity:.9;
     font-size:18px;
    margin-top:3px;
}

.steps{
    display:flex;
    align-items:center;
    gap:18px;
}

.steps span{
    width:42px;
    height:42px;
    border-radius:50%;
    background:rgba(255,255,255,.25);

    display:flex;
    justify-content:center;
    align-items:center;

    font-weight:bold;
    font-size:18px;
}

.steps .completed{
    background:#16c784;
    color:white;
}

.steps .active{
    background:#FFC72C;
    color:#111;
}
.booking-content{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
    padding:25px;
}

.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.section-header h3{
    font-size:24px;
    font-weight:700;
}

.section-header span{
    color:#2f5bea;
    font-weight:600;
}

.services-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:18px;
}

.service-card{
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:20px;
    cursor:pointer;
    transition:.3s;
    background:white;
    min-height:140px;
}

.service-card:hover{
    transform:translateY(-3px);
}

.service-card.active{
    border:2px solid #2f5bea;
    background:#f5f8ff;
}

.service-icon{
    font-size:30px;
    margin-bottom:15px;
}

.service-card h4{
    margin-bottom:8px;
}

.service-card small{
    color:#6b7280;
}

.summary-section{
    border:1px solid #e5e7eb;
    border-radius:20px;
    padding:25px;
}
.summary-row{
    display:flex;
    justify-content:space-between;
    margin:18px 0;
}

.summary-row span{
    color:#666;
}

.total{
    font-size:20px;
    font-weight:bold;
}

.continue-btn{

    width:100%;
    margin-top:30px;

    padding:15px;

    background:#2f5bea;

    color:white;

    border:none;

    border-radius:12px;

    font-size:16px;

    cursor:pointer;
}

.cancel-btn{

    width:100%;

    margin-top:12px;

    padding:15px;

    background:#eceff5;

    border:none;

    border-radius:12px;

    cursor:pointer;
}
.details-card{

    margin-top:30px;

    border:1px solid #e5e7eb;

    border-radius:18px;

    padding:25px;

}

.details-card h4{

    margin-bottom:20px;

}

.weight-header{

    display:flex;

    justify-content:space-between;

    margin-bottom:15px;

}

#weightSlider{

    width:100%;

}

.weight-labels{

    display:flex;

    justify-content:space-between;

    color:#999;

    margin-top:8px;

}

.instructions{

    margin-top:25px;

}

.instructions textarea{

    width:100%;

    height:110px;

    resize:none;

    border:1px solid #ddd;

    border-radius:12px;

    padding:15px;

    font-size:15px;

}
</style>

</style>
    </style>
</head>
<body>

<div class="wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="logo">
            <div class="logo-icon">🧺</div>
            <div class="logo-text">
                <h2>MowingWash</h2>
                <p>Clean clothes, easy life.</p>
            </div>
        </div>

        <ul class="menu">
            <li class="active">
                <a href="#">
                    <i class="fas fa-home"></i> <span>Home</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-circle-plus"></i> <span>New Order</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-list-check"></i> <span>Orders</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-wallet"></i> <span>Wallet</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-calendar"></i> <span>Schedule</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-store"></i> <span>Laundrymats</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-gear"></i> <span>Settings</span>
                </a>
            </li>

            <li class="menu-divider"></li>

            <div class="refer-card">
                <h3>🎁 Refer & Earn</h3>
                <p>Invite friends and earn KSh 200 credit automatically.</p>
                <button>Share Link</button>
            </div>

            <div class="logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </ul>
    </aside>

    <div class="main-content">

        {{-- Top Navigation --}}
        <nav class="navbar">
            <div class="location">
                <i class="fas fa-location-dot"></i>
                <div>
                    <small>Deliver to</small>
                    <strong>
                        {{ auth()->user()->address ?? 'Set your address' }}
                        <i class="fas fa-chevron-down"></i>
                    </strong>
                </div>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search services, laundrymats, offers...">
            </div>

            <div class="nav-right">
                <button class="nav-icon-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notif-dot"></span>
                </button>
                <div class="profile">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <small>Customer</small>
                        <strong>{{ auth()->user()->name }}</strong>
                    </div>
                </div>
            </div>
        </nav>

        <main class="content">
            @yield('content')
        </main>

    </div>

</div>

<script>
   function selectService(name, price, id) {
    window.location.href = `/customer/new-order/${id}`;
}
    

    function switchView(view) {
        window.location.href = '/customer/dashboard?view=' + view;
    }
</script>

</body>
</html>
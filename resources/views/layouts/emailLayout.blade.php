<div class="outerFrame">
    <div style="text-align:center;">
        <img src="{{ logo() }}" alt="{{ basicSystemInfo()->app_name ?? config('app.name') }}" width="80"
            style="margin: 1rem auto; background-color:#ffffff; display:block;">
    </div>
    <div class="mailContent">
        @yield('content')
        <br>

        <p style="margin: 0">Warm regards,</p>
        <p style="margin: 0">{{ basicSystemInfo()->association_acronym ?? config('app.name') }}.</p>
    </div>
</div>

<style>
    .outerFrame {
        width: 100%;
        background: #f0f0f0;
        text-align: center;
        padding: 1rem;
    }

    .mailContent {
        width: 80%;
        background: #ffffff;
        text-align: left;
        margin: 0.2rem auto;
        padding: 1.7rem;
        font-family: Arial, sans-serif;
    }

    .link-button,
    .otp-button {
        display: block;
        width: fit-content;
        margin: 1rem auto;
        padding: 10px 20px;
        background-color: #0b1633;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .otp-button {
        font-size: 1.5rem;
    }

    .link-button:hover,
    .otp-button:hover {
        background-color: #22c55e;
    }
</style>

<x-layout bodyClass="">
    <link rel="stylesheet" href="{{ asset('assets/custom/css/auth.css') }}">
    <div class="container">
        <div class="form_area">
            <div class="app-brand d-flex flex-column align-items-center">
                <div class="logo_area">
                    <img src="{{ asset('assets/custom/img/icons/favicon.png') }}" alt="icon">
                    <span class="brand_name">Imara</span>
                </div>
            </div>

            <form action="" id="loginForm">
                @csrf
                <div class="form_group">
                    <label class="sub_title" for="email">Email</label>
                    <input placeholder="Enter your email" name="email" id="email" class="form_style"
                        type="email">
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" name="password" id="password" class="form_style"
                        type="password">
                </div>
                <div>
                    <div id="messageDiv"></div>
                    <button class="btn">SIGN IN</button>
                    <p>New on our platform? <a class="link" href="{{ route('create.account') }}">Create Here!</a></p>
                </div>
            </form>
        </div>
    </div>
</x-layout>
<script src="{{ asset('assets/custom/js/login.js') }}"></script>

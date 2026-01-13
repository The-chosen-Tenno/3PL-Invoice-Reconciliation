<link rel="stylesheet" href="{{ asset('assets/custom/css/auth.css') }}">
<x-layout bodyClass="">
    <div class="container">
        <div class="form_area">
            <div class="app-brand d-flex flex-column align-items-center">
                <div class="logo_area">
                    <img src="{{ asset('assets/custom/img/icons/favicon.png') }}" alt="icon">
                    <span class="brand_name">Imara</span>
                </div>
            </div>

            <form id="signupForm">
                @csrf
                <div class="form_group">
                    <label class="sub_title" for="full_name">Full Name</label>
                    <input placeholder="Enter your full name" name="full_name" id="full_name" class="form_style"
                        required type="text">
                </div>
                <div class="form_group">
                    <label class="sub_title" for="user_name">User Name</label>
                    <input placeholder="Enter a user name" name="user_name" id="user_name" class="form_style" required
                        type="text">
                </div>
                <div class="form_group">
                    <label class="sub_title" for="email">Email</label>
                    <input placeholder="Enter your email" name="email" id="email" class="form_style" required
                        type="email">
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" name="password" id="password" class="form_style" required
                        type="password">
                </div>
                <div>
                    <button class="btn">SIGN IN</button>
                    <p>Already have an account? <a class="link" href="{{ route('login') }}">Sign in</a></p>
                </div>
            </form>
            <div id="formMessage"></div>
        </div>
    </div>
</x-layout>
<script src="{{ asset('assets/custom/js/create-account.js') }}"></script>

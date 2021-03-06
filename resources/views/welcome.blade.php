@extends('layouts.login')

@section('content')
<style>
    @font-face {
        font-family: "DrukText";
        src: url("../fonts/DrukTextWide-Bold.woff") format("woff");
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: "VanderKeur";
        src: url("../fonts/VanderKeur-Typist-Slab-Regular.woff") format("woff");
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: "VanderKeur-light";
        src: url("../fonts/VanderKeur-Typist-Slab-Thin.woff") format("woff");
        font-weight: normal;
    }

    .logo-login {
        width: 160px;
    }

    input.input100 {

        background: transparent !important;
    }

    .wrap-input100 {

        border-bottom: 1px solid #000000;
    }

    .label-input100 {

        color: #000000;

    }
    .login_admin button {
    outline: none !important;
    border: none;
    background: #111111;
    width: 83%;
    margin-top: 1rem;
}
</style>
<div class="login_admin " id="dev-login">

    <div class="row">
        <!--- <div class="login100-more mask col-md-6"
                style="background-image: url('assets/img/cmsLanding.jpg');">



            </div>--->

        <div class="login100-form validate-form col-md-12" style="background-image: url('assets/img/cmsLanding.jpg');    width: 100%;
    height: 100vh;
    background-size: 100%;padding: 0 30rem;">
            <img class="logo-login" src="{{ asset('assets/img/mainLogo.png') }}">
            <p> Content Management System </p>


            <div class="wrap-input100 validate-input">
                <input class="input100" type="text" v-model="email">
                <span class="focus-input100"></span>
                <span class="label-input100">Email</span>
            </div>


            <div class="wrap-input100 validate-input">
                <input class="input100" type="password" v-model="password">
                <span class="focus-input100"></span>
                <span class="label-input100">Password</span>
            </div>

            <div class="container-login100-form-btn">
                <button class="login100-form-btn" @click="login()">
                    Entrar
                </button>
            </div>

        </div>


    </div>

</div>
@endsection


@push("scripts")

<script type="text/javascript">
    const app = new Vue({
        el: '#dev-login',
        data() {
            return {
                email: "",
                password: ""
            }
        },
        methods: {

            login() {

                axios.post("{{ url('/login') }}", {
                        email: this.email,
                        password: this.password
                    })
                    .then(res => {

                        if (res.data.success == true) {

                            swal({
                                title: "Excelente!",
                                text: res.data.msg,
                                icon: "success"
                            });
                            this.email = ""
                            this.password = ""

                            if (res.data.role_id == 2) {

                                window.location.href = "{{ url('/') }}"


                            } else if (res.data.role_id == 1)
                                window.location.href = res.data.url

                        } else {
                            alert(res.data.msg)
                        }

                    })
                    .catch(err => {

                        $.each(err.response.data.errors, function(key, value) {
                            alert(value)
                        })

                    })

            }

        },
        created() {


        }
    });
</script>

@endpush

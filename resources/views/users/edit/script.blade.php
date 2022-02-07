<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                id:"{{ $user->id }}",
                loading:false,
                name:"{{ $user->name }}",
                password:"",
                email:"{{ $user->email }}",
                errors:[],
                
            }
        },
        methods:{
            
            update(){

               

                this.loading = true
                axios.post("{{ route('users.update') }}", {
                    id:this.id,
                    name:this.name, 
                    email: this.email,
                    password:this.password
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            title: "Excelente!",
                            text: res.data.msg,
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('users.list') }}";
                        });
                        

                    }else{
                    
                        alert(res.data.msg)
                    }

                }).catch(err => {
                    
                    this.loading = false
                    this.errors = err.response.data.errors
                    
                    swal({
                        text: "Hay campos que debes verificar!",
                        icon: "warning"
                    })
                
                })

            },



        },
        mounted(){
            

        }

    })

</script>
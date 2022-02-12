<script>

    var app = new Vue({
        el: '#dev-app',
        data(){
            return{

                projects:[],
                showMenu:false


            }
        },
        methods:{

            async fetch(link = "{{ route('home.fetch') }}"){

                let res = await axios.get(link)
                this.projects = res.data
            },
            erase(id){
                
                swal({
                    title: "¿Estás seguro?",
                    text: "Eliminarás este proyecto!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.loading = true
                        axios.post("{{ route('home.delete') }}", {id: id}).then(res => {
                            this.loading = false
                            if(res.data.success == true){
                                swal({
                                    title: "Genial!",
                                    text: res.data.msg,
                                    icon: "success"
                                });
                                this.fetch()
                            }else{

                                swal({
                                    title: "Lo sentimos!",
                                    text: res.data.msg,
                                    icon: "error"
                                });

                            }

                        }).catch(err => {
                            this.loading = false
                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });
                        })

                    }
                });

            }


        },
        mounted(){

           this.fetch()

        }

    })

</script>
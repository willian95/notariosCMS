<script>

    var app = new Vue({
        el: '#dev-app',
        data(){
            return{

                homeOrderId:"",
                homeOrders:[],
                projects:[],
                showMenu:false,
                order:"",
                selectedProject:""

            }
        },
        methods:{

            async fetch(){

                let res = await axios.get("{{ route('home.fetch') }}")
                this.homeOrders = res.data

            },
            async fetchProject(){

                let res = await axios.get("{{ route('projects.fetch.all') }}")
                this.projects = res.data

            },
            edit(project){

                this.homeOrderId = project.id
                this.order = project.order
                this.selectedProject = project.project_id

            },
            async store(){

                axios.post("{{ route('home.store') }}", {
                    project_id:this.selectedProject, 
                    order: this.order
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){
                        var _this = this
                        swal({
                            title: "Excelente!",
                            text: "Proyecto creado!",
                            icon: "success"
                        }).then(function() {
                            _this.fetch()
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
            async update(){

                axios.post("{{ route('home.update') }}", {
                    homeOrderId:this.homeOrderId,
                    project_id:this.selectedProject, 
                    order: this.order
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){
                        var _this = this
                        swal({
                            title: "Excelente!",
                            text: "Proyecto actualizado!",
                            icon: "success"
                        }).then(function() {
                            _this.fetch()
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
            erase(id){
                
                swal({
                    title: "¿Estás seguro?",
                    text: "Eliminarás este proyecto del home!",
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
           this.fetchProject()

        }

    })

</script>
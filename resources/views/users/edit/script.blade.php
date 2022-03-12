<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                id:"{{ $user->id }}",
                loading:false,
                name:"{{ $user->name }}",
                email:"{{ $user->email }}",
                password: "{{ $user->password }}",
                secondaryContent:JSON.parse('{!! $secondaryContents !!}'),
                selectedProject:"",
                projects:[],
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
                    secondaryContent:this.secondaryContent
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
            async getProjects(){

                const response = await axios.get("{{ route('projects.fetch.all') }}")
                this.projects = response.data

            },
            addProject(){

                this.secondaryContent.push({"project_id": this.selectedProject})

            },
            deleteWorkImage(index){

                this.secondaryContent.splice(index, 1)

            }



        },
        mounted(){
            
            this.getProjects()

        }

    })

</script>
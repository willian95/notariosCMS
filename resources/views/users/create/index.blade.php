@extends("layouts.main")

@section("content")


    <div class="d-flex flex-column-fluid" id="dev-app">
        <div class="loader-cover-custom" v-if="loading == true">
			<div class="loader-custom"></div>
		</div>
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Crear usuario
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" v-model="name">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" v-model="email">
                                <small v-if="errors.hasOwnProperty('email')">@{{ errors['email'][0] }}</small>
                                
                            </div>

                        </div>

                       

                    </div>

                    
                    <div class="row">
                        <div class="col-12">
                        <h3 class="text-center">Contenido secundario <button class="btn btn-success" data-toggle="modal" data-target="#secondaryContent">+</button></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered table-checkable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Proyecto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody v-if="secondaryContent">
                                    <tr v-for="(content, index) in secondaryContent">
                                        <td>@{{ index + 1 }}</td>

                                        <td>
                                            @{{ projects.find(data => data.id == content.project_id).name }}
                                        </td>
                                        
                                        <td>
                                            <button class="btn btn-danger" @click="deleteWorkImage(index)"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>


                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" @click="store()">Crear</button>
                            </p>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="secondaryContent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                                <select class="form-control" v-model="selectedProject">
                                    <option :value="project.id" v-for="project in projects">@{{ project.name }}</option>
                                </select>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="addProject()">Agregar proyecto</button>
                            </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->


    </div>

@endsection

@push("scripts")

    @include("users.create.script")

@endpush

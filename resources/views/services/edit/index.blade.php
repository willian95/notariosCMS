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
                        <h3 class="card-label">Editar servicio
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
                                <label for="description">Tipo</label>
                                <select v-model="type" class="form-control">
                                    <option value="Photography">Photography</option>
                                    <option value="Location">Location</option>
                                </select>
                                <small v-if="errors.hasOwnProperty('description')">@{{ errors['description'][0] }}</small>
                            </div>

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-12">
                        <h3 class="text-center">Contenido secundario <button class="btn btn-success" @click="openSecondaryImageUpload()" >+</button></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered table-checkable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Imágen</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(workImage, index) in workImages">
                                        <td>@{{ index + 1 }}</td>

                                        <td>
                                            <img :src="workImage.finalName" style="width: 40%;">
        
                                        </td>
                                        <td>

                                            <div v-if="workImage.status == 'subiendo'" class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" :style="{'width': `${workImage.progress}%`}">
                                                @{{ workImage.progress }}%
                                            </div>

                                            <p v-if="workImage.status == 'subiendo' && workImage.progress < 100">Subiendo</p>
                                            <p v-if="workImage.status == 'subiendo' && workImage.progress == 100">Espere un momento</p>
                                            <p v-if="workImage.status == 'listo' && workImage.progress == 100">Contenido listo</p>
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
                                <button class="btn btn-success" @click="store()">Actualizar</button>
                            </p>
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
    <script src="{{ url('ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

    @include("services.edit.script")

@endpush

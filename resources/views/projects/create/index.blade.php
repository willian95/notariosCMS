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
                        <h3 class="card-label">Crear proyecto
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Título</label>
                                <input type="text" class="form-control" v-model="name">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                
                            </div>

                            
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Imágen o vídeo (1024x900px | max: 8 Mb )</label>
                                <p>
                                    <button @click="uploadImage()" class="btn btn-info">Upload files</button>
                                </p>

                                <img v-if="imageFileType == 'image'" :src="imagePreview" style="width: 40%;">
                                <video class="w-100" controls v-if="imagePreview != '' && imagePreview == 'video'">
                                    <source :src="imagePreview" type="video/mp4">
                                    <source :src="imagePreview" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                        {{--<div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea rows="3" id="editor1"></textarea>
                                <small v-if="errors.hasOwnProperty('description')">@{{ errors['description'][0] }}</small>
                            </div>
                        </div>--}}

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
                                        <th>Imágen o vídeo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(workImage, index) in workImages">
                                        <td>@{{ index + 1 }}</td>

                                        <td>
                                            <img v-if="workImage.image.indexOf('image') >= 0" :src="workImage.image" style="width: 40%;" v-if="workImage.type == 'image'">
                                            <video class="w-100" controls v-if="workImage.image != '' && workImage.type == 'video'">
                                                <source :src="workImage.image" type="video/mp4">
                                                <source :src="workImage.image" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
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
                                <button class="btn btn-success" @click="store()">Crear</button>
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
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

    @include("projects.create.script")

@endpush

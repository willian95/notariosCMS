@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-app">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Orden home
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <button class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#orderHome">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Nuevo proyecto</button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" style="">
                        <table class="table">
                            <thead>
                                <tr >

                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Nombre</span>
                                    </th>

                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Orden</span>
                                    </th>

                                    <th class="datatable-cell datatable-cell-sort" style="width: 170px;">
                                        <span>Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="homeOrder in homeOrders">
                                    <td class="datatable-cell">
                                        @{{ projects.find(data => data.id == homeOrder.project_id).name }}
                                    </td>

                                    <td class="datatable-cell">
                                        @{{ homeOrder.order }}
                                    </td>
                                    
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#orderHomeUpdate" @click="edit(homeOrder)" ><i class="far fa-edit"></i></button>
                                        <button class="btn btn-secondary" @click="erase(homeOrder.id)"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <!--end: Datatable-->

                </div>

                <!-- Modal -->
                <div class="modal fade" id="orderHome" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                            <div class="form-group">
                                <label for="">Orden</label>
                                <input type="text" class="form-control" v-model="order">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="store()">Agregar proyecto</button>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="orderHomeUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                            <div class="form-group">
                                <label for="">Orden</label>
                                <input type="text" class="form-control" v-model="order">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="update()">Actualizar proyecto</button>
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

@push('scripts')

    @include('homeOrder.script')

@endpush
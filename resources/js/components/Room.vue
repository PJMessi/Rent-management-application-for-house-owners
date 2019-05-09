<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Rooms' Information                      
                        </h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <button @click="show_add_room()" class="btn btn-success">Add New <i class="fas fa-user-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Rent Amount</th>
                                    <th></th>
                                </tr>
                                <tr v-for="(room, index) in rooms.data" v-bind:key="room.id">
                                    <td>{{(rooms.current_page - 1) * rooms.per_page + index+1}}</td>
                                    <td>{{room.name}}</td>
                                    <td>{{room.description}}</td>
                                    <td>Rs {{room.rent_amount}}</td>
                           
                                    <td style="font-size: 1.1rem">
                                        <a href="#" title="Show Details"><i class="fas fa-eye blue"></i></a> &nbsp;
                                        <a href="#" @click="show_edit_room(room)" title="Edit Room"><i class="fas fa-edit orange"></i></a> &nbsp;
                                        <a href="#" @click="delete_room(room)" title="Delete Room"><i class="fas fa-trash red"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-header">
                        <div class="col-md-4 offset-md-4">
                            <ul class="pagination justify-content-center mb-0 pagination-sm">

                                <li class="page-item" :class="{ 'disabled': !rooms.prev_page_url}">
                                    <a class="page-link" @click="fetch_users(rooms.prev_page_url)">Previous</a>
                                </li>

                                <li class="page-item disabled"><a class="page-link" href="#">{{rooms.current_page}} of {{rooms.last_page}}</a></li>

                                <li class="page-item" :class="{ 'disabled': !rooms.next_page_url}">
                                    <a class="page-link" @click="fetch_users(rooms.next_page_url)" href="#">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="modal fade" id="add_edit_room_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 v-if="!is_edit" class="modal-title" id="exampleModalLongTitle">Add Room</h5>
                        <h5 v-else class="modal-title" id="exampleModalLongTitle">Edit Room Information</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="!is_edit? add_room: edit_room">

                        <div class="modal-body">

                            <div class="row">                            
                                
                                <div class="col-md-12">
                                <div class="form-group">
                                    <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rs</span>
                                    </div>
                                    <input v-model="form.rent_amount" type="text" name="rent_amount" class="form-control" :class="{ 'is-invalid': form.errors.has('rent_amount') }" placeholder="Rent Amount">
                                    <has-error :form="form" field="rent_amount"></has-error>
                                </div>

                                <div class="form-group">
                                    <textarea v-model="form.description" name="description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }" placeholder="Room Description"></textarea>
                                    <has-error :form="form" field="description"></has-error>
                                </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-if="!is_edit" type="button" :disabled="form.busy" class="btn btn-success" @click.prevent="add_room">
                                <span>Add Room</span>  
                            </button>
                            <button v-else type="button" :disabled="form.busy" class="btn btn-success" @click.prevent="edit_room">
                                <span>Save Changes</span>  
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    </div>    
</template>

<script>
    export default {
        data() {
            return {
                rooms: {},
                form: new Form({
                    id: '',
                    name: '',
                    rent_amount: '',
                    description: '',
                }),                
                is_edit: false
            }
        },

        created() {
            this.fetch_rooms();
            Fire.$on("rooms_table_changed", () => {
                this.fetch_rooms();
            });
        },

        methods: {
            fetch_rooms(url = "api/room") {
                this.$Progress.start();
                axios.get(url)
                .then((response) => {
                    this.rooms = response.data;
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log("Caught Error: " + error);
                    this.$Progress.fail();
                });
            },

            show_add_room(){
                this.form.reset();
                this.is_edit = false;
                $("#add_edit_room_modal").modal("show");
            },

            add_room() {
                this.$Progress.start();
                this.form.post('api/room')
                .then(({ data }) => {
                    Fire.$emit("rooms_table_changed");
                    $("#add_edit_room_modal").modal("hide");
                    this.$Progress.finish();
                    Toast.fire({
                        type: 'success',
                        title: 'Room Added Successfully'
                    });

                })
                .catch((error) => {
                    console.log("Caught Error: " + error);
                    this.$Progress.fail();
                    Toast.fire({
                        type: 'error',
                        title: 'Failed To Add Room'
                    });
                });
            },

            show_edit_room(room) {
                this.form.fill(room);
                this.is_edit = true;
                $("#add_edit_room_modal").modal("show");
            },

            edit_room() {
                this.$Progress.start();
                this.form.put('api/room/' + this.form.id)
                .then(({ data }) => { 
                    Fire.$emit("rooms_table_changed");
                    $("#add_edit_room_modal").modal("hide");
                    this.$Progress.finish();
                    Toast.fire({
                        type: 'success',
                        title: 'Room Information Updated Successfully'
                    });
                })
                .catch((error) => {
                    this.$Progress.fail();
                    console.log("Caught Error: " + error);
                    Toast.fire({
                        type: 'error',
                        title: 'Failed To Edit Room Information'
                    });
                })
            },

            delete_room(room) {

                Swal.fire({
                    title: 'Are you sure?',
                    //text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                    }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();
                        axios.delete('api/room/' + room.id)
                        .then((response) => {
                            Toast.fire({
                                type: 'success',
                                title: 'Room Successfully Deleted'
                            });
                            Fire.$emit("rooms_table_changed");
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Toast.fire({
                                type: 'error',
                                title: 'Failed to Delete Room'
                            });
                            this.$Progress.fail();
                        })
                    }
                })


                
            }
        }
    }
</script>

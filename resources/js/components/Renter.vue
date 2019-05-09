<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Renters' Information                      
                        </h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <button @click="show_add_renter()" class="btn btn-success">Add New <i class="fas fa-user-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>SN</th>
                                    <th>Maturity</th>
                                    <th>Name</th>
                                    <th>Phone Numbers</th>
                                    <th>Permanent Address</th>
                                    <th>Joined Date</th>
                                    <th>Due Amount</th>
                                    <th></th>
                                </tr>
                                <tr v-for="(renter, index) in renters.data" v-bind:key="renter.id">
                                    <td>{{(renters.current_page - 1) * renters.per_page + index+1}}</td>
                                    <td v-if="renter.is_child == 1">Child</td><td v-else>Adult</td>
                                    <td>{{renter.f_name}} {{renter.l_name}}</td>
                                    <td>{{renter.phone_1}}<span v-if="renter.phone_2">, {{renter.phone_2}}</span></td>
                                    <td>{{renter.p_address}}</td>
                                    <td>{{renter.date_of_join | format_date}}</td>
                                    <td>Rs {{renter.due_amount}}</td>
                           
                                    <td style="font-size: 1.1rem">
                                        <a href="#" @click="view_renter(renter)" title="Show Details"><i class="fas fa-eye blue"></i></a> &nbsp;
                                        <a href="#" @click="show_edit_renter(renter)" title="Edit Renter"><i class="fas fa-user-edit orange"></i></a> &nbsp;
                                        <a href="#" @click="delete_renter(renter)" title="Delete Renter"><i class="fas fa-user-times red"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-header">
                        <div class="col-md-4 offset-md-4">
                            <ul class="pagination justify-content-center mb-0 pagination-sm">

                                <li class="page-item" :class="{ 'disabled': !renters.prev_page_url}">
                                    <a class="page-link" @click="fetch_users(renters.prev_page_url)">Previous</a>
                                </li>

                                <li class="page-item disabled"><a class="page-link" href="#">{{renters.current_page}} of {{renters.last_page}}</a></li>

                                <li class="page-item" :class="{ 'disabled': !renters.next_page_url}">
                                    <a class="page-link" @click="fetch_users(renters.next_page_url)" href="#">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>    

        <!--add and edit modal-->
        <div class="modal fade" id="add_edit_renter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 v-if="!is_edit" class="modal-title" id="exampleModalLongTitle">Add Renter</h5>
                        <h5 v-else class="modal-title" id="exampleModalLongTitle">Edit Renter Information</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="!is_edit? add_renter: edit_renter">

                        <div class="modal-body">

                            <div class="row">                            
                                <div class="col-md-6">

                                    <div class="form-group">                                    
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="form.is_child" id="cb_is_child">
                                            <label class="form-check-label" for="cb_is_child">
                                                This renter is a child
                                            </label>
                                            <has-error :form="form" field="is_child"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.f_name" type="text" name="f_name" class="form-control" :class="{ 'is-invalid': form.errors.has('f_name') }" placeholder="First Name">
                                        <has-error :form="form" field="f_name"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.l_name" type="text" name="l_name" class="form-control" :class="{ 'is-invalid': form.errors.has('l_name') }" placeholder="Last Name">
                                        <has-error :form="form" field="l_name"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text text-muted">Enter parent's email, if the renter is a child</small>
                                        <input v-model="form.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email Address">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text text-muted">Enter parent's phone no, if the renter is a child</small>
                                        <input v-model="form.phone_1" type="text" name="phone_1" class="form-control" :class="{ 'is-invalid': form.errors.has('phone_1') }" placeholder="Primary Phone Number">
                                        <has-error :form="form" field="phone_1"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.phone_2" type="text" name="phone_2" class="form-control" :class="{ 'is-invalid': form.errors.has('phone_2') }" placeholder="Secondary Phone Number">
                                        <has-error :form="form" field="phone_2"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.p_address" type="text" name="p_address" class="form-control" :class="{ 'is-invalid': form.errors.has('p_address') }" placeholder="Permanent Address">
                                        <has-error :form="form" field="p_address"></has-error>
                                    </div>
                                                    

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <small class="form-text text-muted">Date of Birth</small>
                                        <input placeholder="Date of Birth" v-model="form.date_of_birth" type="date" name="date_of_birth" class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_birth') }">
                                        <has-error :form="form" field="date_of_birth"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <small class="form-text text-muted">Joined Date</small>
                                        <input placeholder="Joined Date" v-model="form.date_of_join" type="date" name="date_of_join" class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_join') }">
                                        <has-error :form="form" field="date_of_join"></has-error>
                                    </div>

                                    <div class="form-group">     
                                        <small class="form-text text-muted">Renter Image</small>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" @change="convert_img">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-if="!is_edit" type="button" :disabled="form.busy" class="btn btn-success" @click.prevent="add_renter">
                                <span>Add User</span>  
                            </button>
                            <button v-else type="button" :disabled="form.busy" class="btn btn-success" @click.prevent="edit_user">
                                <span>Save Changes</span>  
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--view modal-->
        <div class="modal fade" id="view_renter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Renter Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>Attribute</th>
                                    <th>Data</th>
                                </tr>
                                <tr>
                                    <td>Maturity</td>
                                    <td v-if="form.is_child == 0">Adult</td><td v-else>Child</td>
                                </tr>
                                <tr>
                                    <td>Renter Photo</td>
                                    <td v-if="form.photo"><img style="width: 100px" class="img-circle" :src="get_user_image()" alt="User Profile Image"></td>
                                    <td v-else>Profile Image Not Set</td>
                                </tr>
                                <tr>
                                    <td>First Name</td>
                                    <td>{{form.f_name}}</td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td>{{form.l_name}}</td>
                                </tr>
                                <tr>
                                    <td>Phone Number 1</td>
                                    <td>{{form.phone_1}}</td>
                                </tr>
                                <tr>
                                    <td>Phone Number 2</td>
                                    <td v-if="form.phone_2">{{form.phone_2}}</td>
                                    <td v-else>Secondary Phone No. Not Set</td>
                                </tr>
                                <tr>
                                    <td>Permanent Address</td>
                                    <td>{{form.p_address}}</td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>{{form.date_of_birth | format_date}}</td>
                                </tr>                                
                                <tr>
                                    <td>Joined Date</td>
                                    <td>{{form.date_of_join | format_date}}</td>
                                </tr> 
                                <tr>
                                    <td>Email</td>
                                    <td>{{form.email}}</td>
                                </tr>   
                                <tr>
                                    <td>Due Amount</td>
                                    <td :class="[form.due_amount > 0?'red':'green']">Rs {{form.due_amount}}</td>
                                </tr>                              
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                
                </div>
            </div>
        </div>

    </div>    
</template>

<script>
export default {
    data() {
        return {
            renters: {},
            form: new Form({
                id: '',
                f_name: '',
                l_name: '',
                p_address: '',
                phone_1: '',
                phone_2: '',
                email: '',
                photo: '',
                date_of_birth: '',
                date_of_join: '',
                due_amount: '',
                is_child: false,
            }),
            rooms: {},
            is_edit: false
        }
    },

    created() {
        this.fetch_renters();
        Fire.$on("renters_table_changed", () => {
            this.fetch_renters();
        });
    },
    
    methods: {
        fetch_renters(url = "api/renter") {
            this.$Progress.start();
            axios.get(url)
            .then((response) => {
                this.renters = response.data[0];
                this.rooms = response.data[1];
                this.$Progress.finish();
            })
            .catch((error) => {
                console.log("Caught Error: " + error);
                this.$Progress.fail();
            });
        },

        show_add_renter(){
            this.form.reset();
            this.is_edit = false;
            $("#add_edit_renter_modal").modal("show");
        },

        convert_img(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            if(file["size"] < 2097152) {
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
            }
            else {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Choose image of size less than 2 MB',
                })
            }
            reader.readAsDataURL(file);
        },

        add_renter() {
            this.$Progress.start();
            this.form.post('api/renter')
            .then(({ data }) => {
                Fire.$emit("renters_table_changed");
                $("#add_edit_renter_modal").modal("hide");
                this.$Progress.finish();
                Toast.fire({
                    type: 'success',
                    title: 'Renter Added Successfully'
                });

            })
            .catch((error) => {
                console.log("Caught Error: " + error);
                this.$Progress.fail();
                Toast.fire({
                    type: 'error',
                    title: 'Failed To Add Renter'
                });
            });
        },

        show_edit_renter(renter) {
            this.form.fill(renter);
            this.is_edit = true;
            $("#add_edit_renter_modal").modal("show");
        },

        edit_user() {
            this.$Progress.start();
            this.form.put('api/renter/' + this.form.id)
            .then(({ data }) => { 

                Fire.$emit("renters_table_changed");   
                this.$Progress.finish();
                $("#add_edit_renter_modal").modal("hide");
                Toast.fire({
                    type: 'success',
                    title: 'Renter Information Updated Successfully'
                });
            })
            .catch((error) => {
                this.$Progress.fail();
                console.log("Caught Error: " + error);
                Toast.fire({
                    type: 'error',
                    title: 'Failed To Edit Renter Information'
                });
            })
        },

        view_renter(renter) {
            this.form.fill(renter);
            $("#view_renter_modal").modal("show");
        },

        delete_renter(renter) {
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
                    axios.delete('api/renter/' + renter.id)
                    .then((response) => {
                        Toast.fire({
                            type: 'success',
                            title: 'Renter Successfully Deleted'
                        });
                        Fire.$emit("renters_table_changed");
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        Toast.fire({
                            type: 'error',
                            title: 'Failed to Delete Renter'
                        });
                        this.$Progress.fail();
                    })
                }
            })
        }
    }
}
</script>

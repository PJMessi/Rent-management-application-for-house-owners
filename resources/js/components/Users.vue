<template>
    <div class="container">
        <div class="row justify-content-center" v-if="$gate.isAdmin()">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Users' Information                      
                        </h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <button @click="show_add_user" class="btn btn-success">Add New <i class="fas fa-user-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Permanent Address</th>
                                    <th>Temp Address</th>
                                    <th>Joined Date</th>
                                    <th></th>
                                </tr>
                                <tr v-for="(user, index) in users.data" v-bind:key="user.id">
                                    <td>{{(users.current_page - 1) * users.per_page + index+1}}</td>
                                    <td>{{user.role | capitalize}}</td>
                                    <td><span>{{user.f_name}}</span> <span>{{user.l_name}}</span></td>
                                    <td><span>{{user.phone_1}}</span><span v-if="user.phone2">, {{user.phone_2}}</span></td>
                                    <td>{{user.p_address}}</td>
                                    <td>{{user.t_address}}</td>
                                    <td>{{user.date_of_join | format_date}}</td>
                                    <td style="font-size: 1.1rem">
                                        <a href="#" @click="view_user(user)" title="Show Details"><i class="fas fa-eye blue"></i></a> &nbsp;
                                        <a href="#" v-if="user.role != 'admin'" @click="show_edit_user(user)" title="Edit User"><i class="fas fa-user-edit orange"></i></a> &nbsp;
                                        <a href="#" v-if="user.role != 'admin'" @click="delete_user(user)" title="Delete User"><i class="fas fa-user-times red"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-header">
                        <div class="col-md-4 offset-md-4">
                            <ul class="pagination justify-content-center mb-0 pagination-sm">

                                <li class="page-item" :class="{ 'disabled': !users.prev_page_url}">
                                    <a class="page-link" @click="fetch_users(users.prev_page_url)">Previous</a>
                                </li>

                                <li class="page-item disabled"><a class="page-link" href="#">{{users.current_page}} of {{users.last_page}}</a></li>

                                <li class="page-item" :class="{ 'disabled': !users.next_page_url}">
                                    <a class="page-link" @click="fetch_users(users.next_page_url)" href="#">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row justify-content-center" v-else>
            <not-found></not-found>
        </div>
        <!-- add and edit modal -->
        <div class="modal fade" id="add_edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 v-if="!is_edit" class="modal-title" id="exampleModalLongTitle">Add User</h5>
                        <h5 v-else class="modal-title" id="exampleModalLongTitle">Edit User Information</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="!is_edit? add_user: edit_user">

                        <div class="modal-body">

                            <div class="row">                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input v-model="form.f_name" type="text" name="f_name" class="form-control" :class="{ 'is-invalid': form.errors.has('f_name') }" placeholder="First Name">
                                        <has-error :form="form" field="f_name"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.l_name" type="text" name="l_name" class="form-control" :class="{ 'is-invalid': form.errors.has('l_name') }" placeholder="Last Name">
                                        <has-error :form="form" field="l_name"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email Address">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>

                                    <div class="form-group">
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
                                    
                                    <div class="form-group">
                                        <input v-model="form.t_address" type="text" name="t_address" class="form-control" :class="{ 'is-invalid': form.errors.has('t_address') }" placeholder="Temporary Address">
                                        <has-error :form="form" field="t_address"></has-error>
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
                                        <input v-model="form.date_of_join" type="date" name="date_of_join" class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_join') }">
                                        <has-error :form="form" field="date_of_join"></has-error>
                                    </div>

                                    <div class="form-group">                                    
                                        <select class="custom-select" v-model="form.role" name="role" :class="{ 'is-invalid': form.errors.has('role') }">
                                            <option selected value="">Choose User Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="renter">Renter</option>
                                        </select>
                                        <has-error :form="form" field="role"></has-error>
                                    </div>

                                    <div class="form-group">     
                                        <small class="form-text text-muted">Profile Image</small>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" @change="convert_img">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.password" type="password" name="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                                        <has-error :form="form" field="password"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-if="!is_edit" type="button" :disabled="form.busy" class="btn btn-success" @click.prevent="add_user">
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

        <!-- view modal -->
        <div class="modal fade" id="view_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
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
                                    <td>Role</td>
                                    <td>{{form.role | capitalize}}</td>
                                </tr>
                                <tr>
                                    <td>Profile Image</td>
                                    <td><img v-if="form.photo" style="width: 100px" class="img-circle" :src="get_user_image()" alt="User Profile Image"></td>
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
                                    <td>{{form.phone_2}}</td>
                                </tr>
                                <tr>
                                    <td>Permanent Address</td>
                                    <td>{{form.p_address}}</td>
                                </tr>
                                <tr>
                                    <td>Temporary Address</td>
                                    <td>{{form.t_address}}</td>
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
                users: {},
                form: new Form({
                    id: '',
                    f_name: '',
                    l_name: '',
                    phone_1: '',
                    phone_2: '',
                    p_address: '',
                    t_address: '',
                    date_of_birth: '',
                    date_of_join: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role: '',
                    photo: '',
                }),

                is_edit: false,
            }
        },

        created() {
            this.fetch_users();
            Fire.$on("users_table_changed", () => {
                this.fetch_users();
            })

            Fire.$on("search", () => {
                let query = this.$parent.search_terms;
                axios.get("api/search?q=" + query)
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.log("Caught Error: " + error);
                })
            });
        }, 

        methods: {
            fetch_users(url = 'api/user') {
                if(this.$gate.isAdmin()) {
                    this.$Progress.start();
                    axios.get(url)
                    .then((response) => {
                        this.users = response.data;
                        this.$Progress.finish();
                    })
                    .catch((error) => {
                        this.$Progress.fail();
                        console.log("Caught Error: " + error);
                    });
                }
            },

            show_add_user() {
                this.form.reset();
                this.is_edit = false;
                $("#add_edit_user_modal").modal("show");
            },

            add_user() {
                this.$Progress.start();

                this.form.post('api/user')
                .then(({ data }) => { 

                    Fire.$emit("users_table_changed");
                    this.loading = false;
                    this.$Progress.finish();
                    $("#add_edit_user_modal").modal("hide");
                    Toast.fire({
                        type: 'success',
                        title: 'User Added Successfully'
                    });
                })
                .catch((error) => {
                    this.loading = false;
                    this.$Progress.fail();
                    console.log("Caught Error: " + error);
                    Toast.fire({
                        type: 'error',
                        title: 'Failed To Add User'
                    });
                })
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

            view_user(user) {
                this.form.fill(user);
                $("#view_user_modal").modal("show");
            },
            
            get_user_image() {
                let path ="./images/users/" + this.form.photo  ;
                return path;
            },

            show_edit_user(user) {
                this.form.fill(user);
                this.is_edit = true;
                $("#add_edit_user_modal").modal("show");
            },

            edit_user() {
                this.$Progress.start();
                this.form.put('api/user/' + this.form.id)
                .then(({ data }) => { 

                    Fire.$emit("users_table_changed");
                    this.loading = false;
                    this.$Progress.finish();
                    $("#add_edit_user_modal").modal("hide");
                    Toast.fire({
                        type: 'success',
                        title: 'User Information Updated Successfully'
                    });
                })
                .catch((error) => {
                    this.loading = false;
                    this.$Progress.fail();
                    console.log("Caught Error: " + error);
                    Toast.fire({
                        type: 'error',
                        title: 'Failed To Edit User Information'
                    });
                })
            },

            delete_user(user) {

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
                        axios.delete('api/user/' + user.id)
                        .then((response) => {
                            Toast.fire({
                                type: 'success',
                                title: 'User Successfully Deleted'
                            });
                            Fire.$emit("users_table_changed");
                            this.$Progress.finish();
                        })
                        .catch((error) => {
                            Toast.fire({
                                type: 'error',
                                title: 'Failed to Delete User'
                            });
                            this.$Progress.fail();
                        })
                    }
                })


                
            }
        }
    }
</script>

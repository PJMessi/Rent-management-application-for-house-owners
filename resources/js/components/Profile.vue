<template>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->

                    <div class="widget-user-header bg-info-active">
                        <h3 class="widget-user-username">{{form.f_name}} {{form.l_name}}</h3>
                        <h5 class="widget-user-desc">{{form.role | capitalize}}</h5>
                    </div>

                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" :src="get_user_image()" alt="User Avatar">
                    </div>

                    <div class="card-footer">
                        <div class="row justify-content-center">
                        
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{form.date_of_join | format_date}}</h5>
                                    <span class="description-text">Joined Date</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                   
                    <div class="tab-pane active show" id="settings">
                        <form class="form-horizontal">
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

                                    <div v-if="form.role == 'admin'" class="form-group">                                    
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
                            <div class="row justify-content-center">
                                <button type="button" :disabled="form.busy" class="btn btn-success" @click.prevent="edit_profile">
                                    <span>Update Changes</span>  
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
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
            }
        },

        created(){
            this.fetch_profile();
        },

        methods: {
            fetch_profile() {
                this.$Progress.start();
                axios.get('api/profile')
                .then((response) => {
                    this.form.fill(response.data);
                    this.$Progress.finish();
                })
                .catch((error) => {
                    this.$Progress.fail();
                    console.log("Caught Error: " + error);
                });
            },

            get_user_image() {
                let path;
                if(this.form.photo) {
                    path =  "./images/users/" + this.form.photo;
                }
                else {
                    path =  "./images/users/default.png";
                }
                return path;
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

            edit_profile() {
                this.$Progress.start();
                this.form.put('api/profile/')
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
        }
    }
</script>

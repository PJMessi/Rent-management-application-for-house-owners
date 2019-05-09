<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                <section class="content">

                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{this.db_info.rooms_count}}</h3>

                                    <p>Total Rooms</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <router-link  to="room" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link >
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{this.db_info.rentees_count}}</h3>

                                    <p>Total Rentees</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <router-link to="renter" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{db_info.users_count}}</h3>

                                    <p>Renters</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>

                </section>              

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            db_info: {
                users_count: '',
                rentees_count: '',
                rooms_count: ''
            }
        }
    },

    created() {
        this.fetch_dashboard_info();
    },

    methods: {
        fetch_dashboard_info() {
            this.$Progress.start();
            axios.get('api/dashboard')
            .then((response) => {
                this.db_info = response.data;
                this.$Progress.finish();
            })
            .catch((error) => {
                console.log("Caught Error: " + error);
                this.$Progress.fail();
            });
        }
    }
}
</script>

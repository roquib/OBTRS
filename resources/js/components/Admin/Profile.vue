
<style media="screen">
  .widget-user-header {
      background-position: center center;
      background-size: cover;
  }
</style>

<template>
  <div class="row">
    <div class="col-md-11 mx-auto">
        <div class="row">

          <!-- Profile + Change password -->
          <div class="col-md-4">
            <!-- Profile -->
            <div class="row">
              <div class="col-md-12">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle"
                            :src="'img/profile/'+form.img" style="height: 125px; width: 120px;"
                           alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ form.name }}</h3>

                    <p class="text-muted text-center">Software Engineer</p>
                    <p class="card-text text-center">Gamil: {{ form.email }}</p>
                    <p class="card-text text-center">Mobile: {{ form.mobile }}</p>


                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
            <!-- End Profile -->




            <!-- Change password -->
            <div class="row my-4">
              <div class="col-md-12">
                <div class="card card-success card-outline">
                  <div class="card-body box-profile">
                    <h3 class="profile-username text-center"><b>Change Password</b></h3>

                    <p class="text-muted text-center">You can change your password from here</p>
                    Old Password
                    <div class="input-group input-group-sm mb-2">
                      <input type="password" v-model="form_password.password" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    New Password
                    <div class="input-group input-group-sm mb-2">
                      <input type="password" v-model="form_password.newPassword" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                    Confirm Password
                    <div class="input-group input-group-sm mb-2">
                      <input type="password" v-model="form_password.confirmPassword" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>

                    <small v-if="!passwordMatch" class="text-danger">Passowrd Not Match</small>
                    <a href="#" class="btn btn-success btn-block" @click="changePassword">Submit</a>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Change password -->
          </div>
          <!-- End Profile + Change password -->





          <!-- Other's information -->
          <div class="col-md-8">
            <div class="card card-info card-outline">

              <div class="card-header px-2 py-4">
                <h3 class="mx-3 font-weight-bold">Update Profile</h3>
              </div><!-- /.card-header -->

              <div class="card-body">
                <form @submit.prevent="updateInfo()">

                Name
                <div class="input-group mb-3">
                  <input v-model="form.name" type="text" class="form-control">
                </div>
                Mobile
                <div class="input-group mb-3">
                  <input v-model="form.mobile" type="text" class="form-control">
                </div>
                Email
                <div class="input-group mb-3">
                  <input v-model="form.email" type="text" class="form-control">
                </div>
                User Type
                <div class="input-group mb-3">
                  <input style="text-transform: capitalize" v-model="form.type" readonly type="text" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateInfo">
                  Update
                </button>

                <!-- Update Infor modal -->
                <!-- The Modal -->
                <div class="modal modal-danger" id="updateInfo">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header text-center">
                        <h4 class="modal-title text-center">Do you want to update info?</h4>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body text-right">


                        <button type="submit" class="btn btn-success px-5" >Submit</button>
                        <button type="button" class="btn btn-danger px-4" data-dismiss="modal">No</button>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- End Update Infor modal -->
              </form>
              </div>

            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- End Other's information -->
        </div>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
          return {
            showImage: "img/profile/avatar.png",
            passwordMatch: true,
            passwordMessage: "Password not match",
            form: new Form({
              id: '',
              name: '',
              email: '',
              password: '',
              mobile: '',
              type: '',
              img: ''
            }),
            form_image: new Form({
              id: '',
              image: ''
            }),
            form_password: new Form({
              id: '',
              password: '',
              newPassword: '',
              confirmPassword: '',
            })
          }
        },
        methods: {
          updatePic(e) {
            let image = e.target.files[0]
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
              this.form.img = e.target.result
            }
          },
          loadUsers() {
            axios.get("api/profile")
            .then(({ data })=>(this.form.fill(data)));
          },

          changePassword() {
            if (this.form_password.newPassword.length < 8) {
              this.passwordMatch = false;
              this.passwordMessage = "Password length must be 8 character";
            } else if (this.form_password.confirmPassword.length < 8) {
                this.passwordMatch = false;
                this.passwordMessage = "Password length must be 8 character";
            }
            else if (this.form_password.newPassword == this.form_password.confirmPassword) {
              console.log(strlen(this.form_password.confirmPassword));
              console.log("passowrd match");
            } else {
              this.passwordMatch = false;
              console.log("password not match");
            }
            console.log(this.form_password.newPassword + " " + this.form_password.confirmPassword);
          },
          updateInfo() {
            this.$Progress.start();
            this.form.put('api/user/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#updateInfo").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Product updated successfully'
                })
                this.$Progress.finish();
            })
            .catch(()=>{
              alert('Failed')
            });
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
          this.loadUsers();
          Fire.$on('AfterAction', () => {
            this.loadUsers();
          });
        }
    }
</script>

<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo" style="background: #6574CD">
              <h3 class="card-title bg-indigo text-light">Users Table</h3>

              <div class="card-tools">

                <button type="button" class="btn btn-success" @click="newModal">Add new <i class="fas fa-user-plus"></i> </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Register At</th>
                  <th>Action</th>
                </tr>
                <tr v-for="user in users" :key="user.id">
                  <td> {{ user.id }} </td>
                  <td> {{ user.name | upText }} </td>
                  <td> {{ user.email }} </td>
                  <td> {{ user.type | upText }} </td>
                  <td> {{ user.created_at | myDate }} </td>
                  <td>
                    <!-- <a href="#" @click="editModal(user)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp; -->
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fas fa-trash red" style="font-size: 25px;"></i>
                    </a>
                  </td>
                </tr>

              </tbody></table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update user</h5>
              <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new user</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editMode ? updateUser() : createUser()">

              <div class="modal-body">

                <div class="form-group">
                  <input v-model="form.name" type="text" name="name" placeholder="Full Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.email" type="text" name="email" placeholder="Email Address"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                  <input  v-model="form.mobile" type="text" name="mobile" placeholder="Mobile Number"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                  <!-- <has-error :form="form" field="mobile"></has-error> -->
                </div>

                <div class="form-group">
                  <select v-model="form.type" name="type" placeholder="User Types" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="">User Type</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="author">Author</option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.password" type="password" name="email" placeholder="Type a password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div>

              </div>


              <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button v-show="editMode" type="submit" class="btn btn-success btn-sm">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary btn-sm">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div> <!-- End modal -->

    </div>
</template>



<script>
    export default {
        data() {
          return {
            editMode: false,
            users: {},
            form: new Form({
              id: '',
              name: '',
              email: '',
              password: '',
              mobile: '',
              type: '',
            })
          }
        },
        methods: {
          editModal(user) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(user);
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteUser(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/user/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'User Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'User Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadUsers() {
            axios.get("api/user").then(({ data }) => (this.users = data.data));
          },
          updateUser() {
            this.$Progress.start();
            this.form.put('api/user/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'User updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'User Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createUser() {
            this.$Progress.start();
            this.form.post('api/user')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'User created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadUsers();
          Fire.$on('AfterAction', () => {
            this.loadUsers();
          });
        }
      }
</script>

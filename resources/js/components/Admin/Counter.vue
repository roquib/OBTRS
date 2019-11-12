<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo" style="background: #6574CD">
              <h3 class="card-title bg-indigo text-light">Counter Table</h3>

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
                  <th>Address</th>
                  <th>Feature</th>
                  <th>user_id</th>
                  <th>Action</th>
                </tr>
                <tr v-for="counter in counters" :key="counter.id">
                  <td> {{ counter.id }} </td>
                  <td> {{ counter.counter_name | capitalize }} </td>
                    <td> {{ counter.counter_address }} </td>
                    <td> {{ counter.feature }} </td>
                    <td> {{ counter.user_id }} </td>
                  <td>
                    <a href="#" @click="editModal(counter)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteCounter(counter.id)">
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
              <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Counter</h5>
              <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new Counter</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editMode ? updateCounter() : createCounter()">

              <div class="modal-body">

                <div class="form-group mb-2">
                  <input v-model="form.counter_name" type="text" name="counter_name" placeholder="Counter Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('counter_name') }">
                  <has-error :form="form" field="counter_name"></has-error>
                </div>
                <div class="form-group mb-2">
                  <input v-model="form.counter_address" type="text" name="counter_address" placeholder="Counter Number"
                    class="form-control">
                </div>
                <div class="form-group mb-2">
                  <input v-model="form.feature" type="text" name="feature" placeholder="Wifi,Shoe Box"
                    class="form-control">
                </div>
                <div class="form-group mb-2">
                  <input type="number" v-model="form.user_id" name="user_id" class="form-control" placeholder="User Id">
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
            counters: {},
            form: new Form({
              id: '',
              counter_name: '',
              counter_address: '',
              feature: '',
              user_id: '',
            })
          }
        },
        methods: {
          editModal(counter) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(counter);
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteCounter(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/counter/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Counter Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Counter Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadCounters() {
            axios.get("api/counter").then(({ data }) => (this.counters = data.data));
          },
          updateCounter() {
            this.$Progress.start();
            this.form.put('api/counter/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Counter updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Counter Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createCounter() {
            this.$Progress.start();
            this.form.post('api/counter')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Counter created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadCounters();
          Fire.$on('AfterAction', () => {
            this.loadCounters();
          });
        }
      }
</script>

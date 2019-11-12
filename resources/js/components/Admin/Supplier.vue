<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo" style="background: #6574CD">
              <h3 class="card-title bg-indigo text-light">Supplier Table</h3>

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
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                <tr v-for="supplier in suppliers" :key="supplier.id">
                  <td> {{ supplier.id }} </td>
                  <td> {{ supplier.name | capitalize }} </td>
                    <td> {{ supplier.mobile }} </td>
                    <td> {{ supplier.email }} </td>
                    <td> {{ supplier.address }} </td>
                  <td>
                    <a href="#" @click="editModal(supplier)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteSupplier(supplier.id)">
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
              <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Supplier</h5>
              <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new Supplier</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editMode ? updateSupplier() : createSupplier()">

              <div class="modal-body">

                <div class="form-supplier mb-2">
                  <input v-model="form.name" type="text" name="name" placeholder="Supplier Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-supplier mb-2">
                  <input v-model="form.mobile" type="text" name="mobile" placeholder="Mobile Number"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                  <has-error :form="form" field="mobile"></has-error>
                </div>
                <div class="form-supplier mb-2">
                  <input v-model="form.email" type="email" name="email" placeholder="Email Address"
                    class="form-control">
                </div>
                <div class="form-supplier mb-2">
                  <textarea v-model="form.address" type="text" name="address" placeholder="Supplier Address"
                    class="form-control"></textarea>
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
            suppliers: {},
            form: new Form({
              id: '',
              name: '',
              mobile: '',
              email: '',
              address: '',
            })
          }
        },
        methods: {
          editModal(supplier) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(supplier);
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteSupplier(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/supplier/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Supplier Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Supplier Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadSuppliers() {
            axios.get("api/supplier").then(({ data }) => (this.suppliers = data.data));
          },
          updateSupplier() {
            this.$Progress.start();
            this.form.put('api/supplier/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Supplier updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Supplier Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createSupplier() {
            this.$Progress.start();
            this.form.post('api/supplier')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Supplier created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadSuppliers();
          Fire.$on('AfterAction', () => {
            this.loadSuppliers();
          });
        }
      }
</script>

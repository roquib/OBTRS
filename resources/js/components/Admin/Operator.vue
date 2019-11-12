<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo" style="background: #6574CD">
              <h3 class="card-title bg-indigo text-light">Operator Table</h3>

              <div class="card-tools">

                <button type="button" class="btn btn-success" @click="newModal">Add new <i class="fas fa-user-plus"></i> </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Company logo</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Short Name</th>
                  <th>Address Line1</th>
                  <th>Address Line2</th>
                  <th>Postal Code</th>
                  <th>Action</th>
                </tr>
                <tr v-for="operator in operators" :key="operator.id">
                  <td> {{ operator.id }} </td>
                  <td> {{ operator.company_logo_url}} </td>
                  <td> {{ operator.company_name | capitalize }} </td>
                    <td> {{ operator.company_address }} </td>
                    <td> {{ operator.company_short_name }} </td>
                    <td> {{ operator.address_line1 }} </td>
                    <td> {{ operator.address_line2 }} </td>
                    <td> {{ operator.postal_code }} </td>
                  <td>
                    <a href="#" @click="editModal(operator)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteOperator(operator.id)">
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
              <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Operator</h5>
              <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new Operator</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editMode ? updateOperator() : createOperator()">

              <div class="modal-body">

                <div class="form-group mb-2">
                  <input v-model="form.company_logo_url" type="text" name="company_logo_url" placeholder="company logo url"
                    class="form-control">
                </div>
                <div class="form-group mb-2">
                  <input v-model="form.company_name" type="text" name="company_name" placeholder="company name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('company_name') }">
                  <has-error :form="form" field="company_name"></has-error>
                </div>
                <div class="form-group mb-2">
                  <input v-model="form.company_address" type="text" name="company_address" placeholder="Company Address"
                    class="form-control">
                </div>
                <div class="form-group mb-2">
                  <input v-model="form.company_short_name" type="text" name="company_short_name" placeholder="Short Name"
                    class="form-control">
                </div>
                <div class="form-group mb-2">
                  <textarea v-model="form.address_line1" name="address_line1" placeholder="address_line1"
                    class="form-control"></textarea>
                </div>
                <div class="form-group mb-2">
                  <textarea v-model="form.address_line2" name="address_line2" placeholder="address_line2"
                    class="form-control"></textarea>
                </div><div class="form-group mb-2">
                  <input v-model="form.postal_code" type="text" name="postal_code" placeholder="postal code"
                    class="form-control">
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
            operators: {},
            form: new Form({
              id: '',
              company_logo_url: '',
              company_name: '',
              company_address: '',
              company_short_name: '',
              address_line1: '',
              address_line2: '',
              postal_code: '',
            })
          }
        },
        methods: {
          editModal(operator) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(operator);
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteOperator(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/operator/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Operator Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Operator Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadOperators() {
            axios.get("api/operator").then(({ data }) => (this.operators = data.data));
          },
          updateOperator() {
            this.$Progress.start();
            this.form.put('api/operator/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Operator updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Operator Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createOperator() {
            this.$Progress.start();
            this.form.post('api/operator')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Operator created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadOperators();
          Fire.$on('AfterAction', () => {
            this.loadOperators();
          });
        }
      }
</script>

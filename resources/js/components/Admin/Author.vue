<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header" style="background: #4FC08D">
              <h3 class="card-title text-light font-weight-bold" style="letter-spacing: 3px;">Author List</h3>

              <div class="card-tools">

                <button type="button" class="btn btn-primary" @click="newModal">Add new <i class="fas fa-user-plus"></i> </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th style="min-width: 200px">Name</th>
                  <th>Description</th>
                  <th style="min-width: 100px">URL</th>
                  <th style="min-width: 100px">Action</th>
                </tr>
                <tr v-for="author in authors.data" :key="author.id">
                  <td> {{ author.id }} </td>
                  <td> <b>{{ author.name | upText }}</b> </td>
                  <td> {{ author.description }} </td>
                  <td> <a :href="author.more_about" :title="author.more_about" target="_blank">View Detail</a> </td>
                  <td>
                    <a href="#" @click="editModal(author)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteAuthor(author.id)">
                      <i class="fas fa-trash red" style="font-size: 25px;"></i>
                    </a>
                  </td>
                </tr>

              </tbody></table>
            </div>
            <div class="card-footer">
              <pagination :data="authors" @pagination-change-page="getResults"></pagination>
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
              <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Author</h5>
              <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new Author</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editMode ? updateAuthor() : createAuthor()" enctype="multipart/form-data">

              <div class="modal-body">

                <div class="form-group">
                  <input v-model="form.name" type="text" name="name" placeholder="Author Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <textarea v-model="form.description" name="description" rows="3" cols="80" placeholder="Short Note about author"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                  <has-error :form="form" field="description"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.more_about" type="text" name="more_about" placeholder="Author web link"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('more_about') }">
                  <has-error :form="form" field="more_about"></has-error>
                </div>

                <div class="form-group">
                  <input  type="file" name="image" @change="uploadImage">

                  <img :src="showImage" alt="No image" style="height: 80px; width: 80px; border: 2px solid gray">
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
            authors: {},
            showImage:'',
            form: new Form({
              id: '',
              name: '',
              image: '',
              description: '',
              more_about: ''
            })
          }
        },
        methods: {
          getResults(page = 1) {
          			axios.get('api/author?page=' + page)
          				.then(response => {
          					this.authors = response.data;
          				});
          		},
          uploadImage(e) {
            // console.log('uploading');
            let file = e.target.files[0];
            // console.log(file);
            console.log('Image size is: ' + file['size']);
            let reader = new FileReader();
            reader.onloadend = (file) => {
              this.form.image = reader.result;
              this.showImage = reader.result;
            }
            reader.readAsDataURL(file);
          },
          editModal(author) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(author);
            this.showImage = "img/writer/" + this.form.image;
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteAuthor(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/author/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Author Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Author Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadAuthors() {
            axios.get("api/author").then(({ data }) => (this.authors = data));

          },
          updateAuthor() {
            this.$Progress.start();
            this.form.put('api/author/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Author updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Author Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createAuthor() {
            this.$Progress.start();
            this.form.post('api/author')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Author created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadAuthors();
          Fire.$on('AfterAction', () => {
            this.loadAuthors();
          });
        }
      }
</script>

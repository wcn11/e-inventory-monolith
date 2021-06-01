<template>

    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Tetapkan Tanggal Pengiriman:</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="file"> Tambahkan File Berupa Tipe Ms. Excel. Contoh: .xls, .xlsx, csv, spreadsheet, dll</label>
                            <input type="file" id="file" name="file" class="form-control form-control-border" :class="{'is-invalid': errors[0]}" ref="file" v-on:change="handleFileUpload()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" pattern="^.+\.(xlsx|xls|csv)$" required/>
                            <div class="invalid-feedback text-center" v-if="errors.length > 0">
                                {{ errors[0].message}}
                            </div>

                            <div class="justify-content-center">
                                <span class="badge badge-info position-relative" :style="`left: ${uploadPercentage ? uploadPercentage - 4 : 0}% `"> {{ uploadPercentage }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" :class="{'progress-bar-animated': uploadPercentage < 100}" role="progressbar" max="100" :value.prop="uploadPercentage" aria-valuemin="0" aria-valuemax="100" :style="`width: ${uploadPercentage}%`"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="origin">Asal <span class="text-danger">*</span></label>
                            <input type="text" id="origin" v-model="origin" name="origin" class="form-control form-control-border" required>
                        </div>
                        <div class="form-group">
                            <label for="destination">Destinasi <span class="text-danger">*</span></label>
                            <input type="text" id="destination" v-model="destination" name="destination" class="form-control form-control-border" required>
                        </div>
                        <div class="form-group">
                            <label for="pj">Penanggung Jawab <span class="text-danger">*</span></label>
                            <input type="text" id="pj" v-model="pj" name="pj" class="form-control form-control-border" required>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success float-right" @click="upload"><i class="fas fa-upload"></i> Upload File</button>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="modal-upload">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-warning">
                    <div class="modal-header justify-content-around">
                        <h4 class="modal-title text-center"><i class="fas fa-exclamation-triangle"></i> PERINGATAN <i class="fas fa-exclamation-triangle"></i></h4>
                    </div>
                    <div class="modal-body">
                        <h5>Data yang diupload tidak dapat dikembalikan kembali, Pastikan File Benar!</h5>
                        <small>Catatan: Pastikan File Yang Diupload Sudah Benar</small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fad fa-times-octagon"></i> Batalkan</button>
                        <button type="button" class="btn btn-outline-dark" @click="submitFile"><i class="fas fa-cloud-upload-alt"></i> Upload Sekarang</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
import jquery from 'jquery'
import moment from 'moment'
import Swal from 'sweetalert2'

moment.locale('id');

export default {
    name: "StockTrip",
    components: {
        Swal
    },
    data(){
        return {
            file: '',
            uploadPercentage: 0,
            errors: [],
            origin: '',
            destination: '',
            pj: ''
        }
    },
    methods: {
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        },
        upload(){

            if (this.origin === '' || this.destination === '' || this.pj === ''){

                this.openAlert('warning', 'Harap Isi Bidang Yang Dibutuhkan!')

                this.file = ''

                this.closeModal()

                return
            }

            jquery("#modal-upload").modal('show')

        },
        submitFile(){
            /*
              Initialize the form data
            */
            let formData = new FormData();

            /*
              Add the form data we need to submit
            */
            formData.append('file', this.file);
            formData.append('origin', this.origin);
            formData.append('destination', this.destination);
            formData.append('pj', this.pj);

            /*
              Make the request to the POST /single-file URL
            */
            axios.post( '/api/stock/upload',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.uploadPercentage = Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 );
                    }.bind(this)
                }
            ).then(res => {
                this.closeModal()
                this.openAlert('success', res.data.message)
                window.location.href = '/stock/cek-trip'
            }).catch(err => {
                this.closeModal()
                this.openAlert('error', err.response.data.message)
            });
        },
        openAlert(icon = 'success', message){
            Swal.fire({
                position: 'center',
                icon: icon,
                title: message,
                showConfirmButton: true
            })
        },
        closeModal(){
            this.file = ''
            this.uploadPercentage = 0
            this.errors = []

            jquery("#modal-upload").modal('hide')
        },
        setToday(){
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();
            let hour = today.getHours()
            let minute = today.getMinutes()


            today = mm + '/' + dd + '/' + yyyy + ' ' + hour + ':' + minute;
            this.today = moment(today).format('DD MMMM yyyy, HH:mm');
        }
    },
    mounted(){
        this.setToday()
    }
}
</script>

<style scoped>
    #file{
        cursor: pointer;
    }
</style>

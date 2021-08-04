<template>
    <vue-clip :options="options"  :on-added-file="addedFile" :on-sending="sending">
        <template slot="clip-uploader-action">
            <div>
                <div class="dz-message"><h2> Klik atau Drag and Drop File Untuk Upload </h2></div>
            </div>
        </template>

        <template slot="clip-uploader-body" slot-scope="props">
            <div v-for="file in props.files">
                <img v-bind:src="file.dataUrl" alt="Cover icon" class="img-rounded img-fluid upload-action"/>
                {{ file.name }} {{ file.status }}
            </div>
        </template>

    </vue-clip>
</template>

<script>

export default {
    name: "UploadFile",
    data(){
        return {
            files: [],
            options: {
                url: '/api/barang/upload',
                paramName: 'file',
                headers: {
                    Authorization: 'Bearer ' + BAC.apiToken,
                },
                uploadMultiple: false,
                maxFilesize: {
                    limit: 2,
                    message: 'Ukuran File Lebih Besar! Maks. 3mb',
                },
                maxFiles: {
                    limit: 1,
                    message: 'Hanya Bisa Upload 1 File'
                },

                acceptedFiles: {
                    extensions: ['image/*'],
                    message: 'You are uploading an invalid file'
                }
            }
        }
    },
    methods: {
        addedFile (file) {
            this.files.push(file)
        },
        sending (file, xhr, formData) {
        },

    }
}
</script>

<style scoped>

.upload-action.is-dragging {
    background: green;
}

.dz-message{
    border: 3px dotted blue;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
}
</style>

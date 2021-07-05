<template>
    <div class="wrapper">
        <div class="jumbotron">
            <form>
                <div class="form-group">
                    <label for="date"
                        >Tanggal Stock Opname</label
                    >
                    <input
                        type="date"
                        class="form-control w-25"
                        id="date"
                    />
                </div>
                <div class="form-group">
                    <label for="upload"
                        >Tambahkan File Stock Opname</label
                    >
                    <input
                        type="file"
                        class="form-control-file"
                        id="upload"
                    />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "UploadOpname"
};
</script>

<style></style>

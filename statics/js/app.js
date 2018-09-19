(function (Vue, axios, $) {
    new Vue({
        el: '#perfilCliente',
        data: {
            productos: [],
            referencias: [],
            bitacoras: [],
            dataReferencia: {
                producto: 0,
                notas: ''
            },
            comentarios: '',
            currentReferencia: 0,
            currentEstadoReferencia: 0,
            comentarioEstadoReferencia: '',
            currentBitacora: 0,
            idCliente: '',
            serverURL: '/api/clientes.php'
        },
        mounted: function () {
            this.idCliente = $('input[name=idClienteAJAX]').val();
            console.log(this.idCliente);
            if(this.idCliente>0){
                this.loadData();
            }
        },
        methods: {
            loadData: function () {
                this.loadProductos();
                this.loadRefencias();
                this.loadBitacoras();
            },
            loadProductos: function(){
                var _this = this;
                $.ajax({
                    type: "POST",
                    url: this.serverURL,
                    data: {idCliente: this.idCliente, act: 1},
                    success: function (resp) {
                        _this.productos = JSON.parse(resp);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                    }
                });
            },
            loadRefencias: function(){
                var _this = this;
                $.ajax({
                    type: "POST",
                    url: this.serverURL,
                    data: {idCliente: this.idCliente, act: 2},
                    success: function (resp) {
                        _this.referencias = JSON.parse(resp);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                    }
                });
            },
            loadBitacoras: function(){
                var _this = this;
                $.ajax({
                    type: "POST",
                    url: this.serverURL,
                    data: {idCliente: this.idCliente, act: 3},
                    success: function (resp) {
                        _this.bitacoras = JSON.parse(resp);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                    }
                });
            },
            addReferencia: function() {
                if(this.dataReferencia.producto != 0){
                    var _this = this;
                    $.ajax({
                        type: "POST",
                        url: this.serverURL,
                        data: {act: 4, idCliente: this.idCliente, dataReferencia: this.dataReferencia},
                        success: function (resp) {
                            // console.log(resp);
                            _this.referencias = JSON.parse(resp);
                            _this.dataReferencia.producto = 0;
                            _this.dataReferencia.notas = '';
                            var currentProducto = document.getElementById("selectProducto");
                            currentProducto.remove(currentProducto.selectedIndex);
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                        }
                    });
                }
            },
            confirmRemoveReferencia: function(idReferencia){
                this.currentReferencia = idReferencia;
                $('#modalRemoveReferencia').modal('show');
            },
            removeReferencia: function(){
                // console.log(this.currentReferencia);
                if(this.currentReferencia != 0){
                    var _this = this;
                    $.ajax({
                        type: "POST",
                        url: this.serverURL,
                        data: {act: 5, idCliente: this.idCliente, idReferencia: this.currentReferencia},
                        success: function (resp) {
                            // console.log(resp);
                            $('#modalRemoveReferencia').modal('hide');
                            this.currentReferencia = 0;
                            _this.referencias = JSON.parse(resp);
                            _this.loadProductos();
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                        }
                    });
                }
            },
            confirmCambioEstadoReferencia: function(idReferencia, estadoRefencia){
                this.currentReferencia = idReferencia;
                this.currentEstadoReferencia = estadoRefencia;
                $('#modalCambioEstadoReferencia').modal('show');
            },
            cambiarEstadoReferencia: function(){
                if(this.currentReferencia != 0 && this.currentEstadoReferencia != 0 && this.comentarioEstadoReferencia != ''){
                    var _this = this;
                    $.ajax({
                        type: "POST",
                        url: this.serverURL,
                        data: {act: 6, idCliente: this.idCliente, 
                            idReferencia: this.currentReferencia,
                            estadoReferencia: this.currentEstadoReferencia,
                            comentarioEstadoReferencia: this.comentarioEstadoReferencia},
                        success: function (resp) {
                            // console.log(resp);
                            $('#modalCambioEstadoReferencia').modal('hide');
                            _this.currentReferencia = 0;
                            _this.currentEstadoReferencia = 0;
                            _this.comentarioEstadoReferencia = '';
                            _this.referencias = JSON.parse(resp);
                            _this.loadProductos();
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                        }
                    });
                }
            },
            addBitacora: function() {
                if(this.comentarios != ''){
                    var _this = this;
                    $.ajax({
                        type: "POST",
                        url: this.serverURL,
                        data: {act: 7, idCliente: this.idCliente, comentarios: this.comentarios},
                        success: function (resp) {
                            // console.log(resp);
                            _this.bitacoras = JSON.parse(resp);
                            _this.comentarios = '';
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                        }
                    });
                }
            },
            confirmRemoveBitacora: function(idBitacora){
                this.currentBitacora = idBitacora;
                $('#modalRemoveBitacora').modal('show');
            },
            removeBitacora: function(){
                // console.log(this.currentReferencia);
                if(this.currentBitacora != 0){
                    var _this = this;
                    $.ajax({
                        type: "POST",
                        url: this.serverURL,
                        data: {act: 8, idCliente: this.idCliente, idBitacora: this.currentBitacora},
                        success: function (resp) {
                            // console.log(resp);
                            $('#modalRemoveBitacora').modal('hide');
                            this.currentBitacora = 0;
                            _this.bitacoras = JSON.parse(resp);
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            console.log("Porfavor reporta este error: " + errorThrown + xhr.status + xhr.responseText);
                        }
                    });
                }
            }
        }
    });
})(window.Vue, window.axios, window.$);
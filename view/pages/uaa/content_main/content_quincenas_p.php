<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">LISTADO DE QUINCENAS PAGADAS </h3>
                </div>
                <div class="box-body">
                    <form action="#" method="post" id="frm_quincena_p" class="form-horizontal">
                    	<div class="form-group">
                    		<label class="col-sm-1 control-label">Año:</label>
                    		<div class="col-md-3">
                    			<input type="text" id="year" name="year" value="<?=date('Y')?>" class="form-control" maxlength="4" minlength="4" min="2020" max="<?=date('Y')?>" onkeypress="return event.charCode >= 45 && event.charCode <= 57"  required >
                    		</div>
                    		<label class="col-sm-1 control-label">Quincena: </label>
            				<div class="col-md-3">
            					<select name="quincenas" id="quincenas" class="form-control" required=""></select>
            				</div>
            				<div class="col-md-1">
            					<button type="submit" class="btn btn-success btn-flat btn-block">
            						<i class="fa fa-search"></i>
            					</button>
            				</div>
                    	</div>
                    </form>
                    <div id="tbl_qp"></div>
                </div>
            </div>
        </div>
    </div>
</section>
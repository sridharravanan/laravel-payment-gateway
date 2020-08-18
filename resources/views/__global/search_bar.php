<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 19/8/20
 * Time: 1:19 AM
 */
?>
<div class="form-group">
    <div class="col col-md-12">
        <div class="input-group">
            <input type="text"  placeholder="Search" class="form-control" v-model="vueTableParams.filter" @keyup="reloadRefresh">
            <div class="input-group-btn">
                <button class="btn btn-primary" @click="clearDataTable">
                    <i class="fa fa-eraser"></i> Erase
                </button>
            </div>
        </div>
    </div>
</div>

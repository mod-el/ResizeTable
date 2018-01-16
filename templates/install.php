<style>
    .label{
        width: 50%;
        text-align: right;
        padding-right: 10px;
        padding-bottom: 5px;
        padding-top: 5px;
    }

    .field{
        text-align: left;
        padding-bottom: 5px;
        padding-top: 5px;
    }

    td{
        padding: 5px;
    }
</style>

<h2>Table resize module - Installation</h2>

<form action="" method="post">
	<?php $this->model->_CSRF->csrfInput(); ?>
    <hr />
    <input type="hidden" name="install" value="1" />
    <input type="checkbox" name="crea-tabella" id="tabella" checked /> <label for="tabella">Create table</label><br />
    <br />
    <input type="submit" value="Install" />
</form>
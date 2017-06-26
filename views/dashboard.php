<div id="jimex-dashboard">
    <h1><?= __('WordPress JSON Importer/Exporter', 'jimex'); ?></h1>
    <div class="dashboard__container">
        <div class="dashboard__forms">

            <div class="form form--import">
                <h2><?= __('Import', 'jimex'); ?></h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="page" value="wp-json-importer-exporter">
                    <div>
                        <label for="jimex-import__file">
                            <input type="file" id="jimex-import__file" name="jimex-import__file">
                        </label>
                    </div>
                    <div>
                        <button type="submit" name="action" value="import"><?= __('Import', 'jimex'); ?></button>
                    </div>
                </form>
            </div>

            <div class="form form--export">
                <h2><?= __('Export', 'jimex'); ?></h2>
                <form action="">
                    <input type="hidden" name="page" value="wp-json-importer-exporter">
                    <div>
                        <button type="submit" name="action" value="export"><?= __('Export', 'jimex'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Saved Queries -->
<?php if (config('saved_queries') != NULL && $saved_query_dashboard->rowCount() > 0): ?>
    <?php while($table = $saved_query_dashboard->fetch()): ?>
        <?php $query = $this->database->get_saved_query($table->id); ?>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <!-- Recent Posts -->
                <div class="card mb-4 mt-2">
                    <h6 class="card-header"><?php echo $table->name; ?></h6>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table id="edit-table" class="table table-striped table-bordered">
                                <?php
                                    $key = '';
                                    $pkey_val = '';

                                    echo '<thead><tr class="table-primary">';

                                    for ($i = 0; $i < $query->columnCount(); $i++) {
                                        $col = $query->getColumnMeta($i);

                                        echo '<th>' . $col['name'] . '</th>';
                                    }

                                    echo '</tr></thead><tbody>';

                                    for ($i = 0; $i < $query->rowCount(); $i++) {
                                        $row = $query->fetch(PDO::FETCH_ASSOC);

                                        echo '<tr>';

                                        for ($j = 0; $j < $query->columnCount(); $j++) {
                                            $col = $query->getColumnMeta($j);

                                            if (in_array('primary_key', $col['flags']) == TRUE) {
                                                $key = $col['name'];
                                                $pkey_val = $row[$col['name']];
                                            }

                                            if ($col['native_type'] == "BLOB") {
                                                echo '<td><a href="'.site_url('admin/database/saved_query/'.$table->id.'/'.$pkey_val).'" class="text-dark table-link">'.get_summary($row[$col['name']], 1).'</a></td>';
                                            }
                                            else {
                                                echo '<td><a href="'.site_url('admin/database/saved_query/'.$table->id.'/'.$pkey_val).'" class="text-dark table-link">'.$row[$col['name']].'</a></td>';
                                            }
                                        }

                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<!-- End Saved Queries -->

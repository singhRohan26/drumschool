<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-book-open"></i>Notification
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Date And Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($notifications)) {
                                    $i = 1;
                                    foreach ($notifications as $notification) {
                                        ?>
                            <tr>
                                <td style="width: 20px;"><?php echo $i; ?></td>
                                <td><?php echo $notification['title']; ?></td>
                                <td title="<?php echo $notification['body']; ?>"><?php echo substr($notification['body'],0 ,90); ?>...</td>
                                <td><?php echo $notification['created_at']; ?></td>
                            </tr>
                            <?php
                                $i++;
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header"><i class="fas fa-cogs"></i> <a class="edit_faqs" data-url="<?php echo base_url('admin/faqWrapper');?>" href="javascript:void(0);" data-toggle="modal">Add FAQ's</a></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($faq)) {
                                    $i = 1;
                                    foreach ($faq as $faqs) {
                                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $faqs['question']; ?></td>
                                <td title="<?php echo strip_tags($faqs['answer']); ?>"><?php echo substr($faqs['answer'],0, 400); ?>....</td>
                                <td><a data-placement="top" title="Edit FAQ" data-url="<?php echo base_url('admin/faqWrapper/'. $faqs['id']);?>" href="javascript:void(0)" class="edit_faqs" data-toggle="modal"><i class="fas fa-edit"></i></a></td>
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

<div class="modal fade" id="add_faq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="faq_wrap">

        </div>
    </div>
</div>
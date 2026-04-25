<?php $__env->startSection('title', 'Takas Başvuruları | Nöbet Kontrol'); ?>
<?php $__env->startSection('page-title', 'Nöbet Değişim Talepleri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <p class="text-muted mb-0 small"><i class="bi bi-info-circle me-1 text-primary"></i>Öğretmenler arası nöbet değişim taleplerini buradan takip edip onaylayabilirsiniz.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end">
            <?php if(auth()->user()->isTeacher()): ?>
                <a href="<?php echo e(route('swap-requests.create')); ?>" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow">
                     <i class="bi bi-plus-circle-fill"></i> Yeni Takas Talebi
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?php if($swapRequests->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table align-middle text-light mb-0">
                        <thead class="bg-dark bg-opacity-25">
                            <tr>
                                <th class="ps-4">Talep Sahibi</th>
                                <th>Hedef Öğretmen</th>
                                <th>Görev Bilgisi</th>
                                <th>Tarih</th>
                                <th class="text-center">Durum</th>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <th class="text-end pe-4">Onay / Red</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <?php $__currentLoopData = $swapRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $swap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px; flex-shrink:0;">
                                                <?php echo e(strtoupper(substr($swap->requester->name, 0, 1))); ?>

                                            </div>
                                            <div>
                                                <div class="fw-bold text-light"><?php echo e($swap->requester->name); ?></div>
                                                <div class="text-muted" style="font-size: 11px;"><?php echo e($swap->requester->branch); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-light small"><?php echo e($swap->target->name); ?></div>
                                        <div class="text-muted" style="font-size: 10px;"><?php echo e($swap->target->branch); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-primary small fw-bold">
                                            <i class="bi bi-geo-alt me-1"></i> <?php echo e($swap->dutyAssignment->location->name ?? 'Belirlenmedi'); ?>

                                        </div>
                                    </td>
                                    <td class="text-muted small">
                                        <?php echo e($swap->dutyAssignment->dutySchedule->date->format('d.m.Y') ?? '-'); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $sCls = $swap->status === 'approved' ? 'bg-success' : ($swap->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger');
                                        ?>
                                        <span class="badge <?php echo e($sCls); ?> px-3 py-1 rounded-pill" style="font-size: 10px;">
                                            <?php echo e($swap->status_label); ?>

                                        </span>
                                    </td>
                                    <?php if(auth()->user()->isAdmin()): ?>
                                        <td class="text-end pe-4">
                                            <?php if($swap->isPending()): ?>
                                                <div class="btn-group gap-1">
                                                    <form action="<?php echo e(route('swap-requests.approve', $swap)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-dark border-0 p-2" title="Onayla">
                                                            <i class="bi bi-check-circle-fill text-success"></i>
                                                        </button>
                                                    </form>
                                                    <form action="<?php echo e(route('swap-requests.reject', $swap)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-dark border-0 p-2" title="Reddet">
                                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <small class="text-muted opacity-50" style="font-size: 10px;">
                                                    <?php echo e($swap->responded_at ? $swap->responded_at->format('d.m.Y') : 'İşlem Gördü'); ?>

                                                </small>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-dark bg-opacity-25 d-flex justify-content-center">
                    <?php echo e($swapRequests->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="opacity-10 mb-3"><i class="bi bi-arrow-left-right fs-1" style="font-size: 80px !important;"></i></div>
                    <h5 class="text-muted">Aktif takas talebi bulunamadı.</h5>
                    <?php if(auth()->user()->isTeacher()): ?>
                        <a href="<?php echo e(route('swap-requests.create')); ?>" class="btn btn-primary mt-3 px-5">Talep Oluştur</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/swap_requests/index.blade.php ENDPATH**/ ?>
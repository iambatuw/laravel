

<?php $__env->startSection('title', $location->name . ' - Nöbet Yeri'); ?>
<?php $__env->startSection('page-title', $location->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center py-4">
                    <div style="width:64px;height:64px;border-radius:14px;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;font-size:24px;color:#fff;margin:0 auto 16px;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-1"><?php echo e($location->name); ?></h4>
                    <p class="text-muted mb-3"><?php echo e($location->floor ?? 'Kat belirtilmemiş'); ?></p>

                    <?php if($location->description): ?>
                        <p style="font-size: 13px; color: #777;"><?php echo e($location->description); ?></p>
                    <?php endif; ?>

                    <div class="d-flex justify-content-around mt-3 pt-3 border-top">
                        <div>
                            <div class="fw-bold text-primary" style="font-size: 20px;"><?php echo e($location->capacity); ?></div>
                            <div class="text-muted" style="font-size: 12px;">Kapasite</div>
                        </div>
                        <div>
                            <div class="fw-bold text-success" style="font-size: 20px;"><?php echo e($recentAssignments->total()); ?></div>
                            <div class="text-muted" style="font-size: 12px;">Toplam Atama</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Nöbet Geçmişi</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($recentAssignments->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Öğretmen</th>
                                        <th>Zaman</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo e($assignment->dutySchedule->date->format('d.m.Y')); ?></td>
                                            <td><?php echo e($assignment->teacher->name); ?></td>
                                            <td><span class="badge-status badge-<?php echo e($assignment->period); ?>"><?php echo e($assignment->period_label); ?></span></td>
                                            <td><span class="badge-status badge-<?php echo e($assignment->status); ?>"><?php echo e($assignment->status_label); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            <?php echo e($recentAssignments->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-calendar-x d-block"></i>
                            <h5>Bu lokasyon için nöbet kaydı yok</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/locations/show.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'Silinen Öğretmenler'); ?>
<?php $__env->startSection('page-title', 'Silinen Öğretmenler'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <p class="text-muted mb-0">Silinen öğretmenler burada listelenir. Geri yükleyebilirsiniz.</p>
        <a href="<?php echo e(route('teachers.index')); ?>" class="btn btn-outline-primary" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i>Öğretmenlere Dön
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <?php if($teachers->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Öğretmen</th>
                                <th>E-posta</th>
                                <th>Branş</th>
                                <th>Silinme Tarihi</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($teacher->name); ?></td>
                                    <td style="color: #666;"><?php echo e($teacher->email); ?></td>
                                    <td><?php echo e($teacher->branch); ?></td>
                                    <td style="color: #999;"><?php echo e($teacher->deleted_at->format('d.m.Y H:i')); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('teachers.restore', $teacher->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-sm btn-primary-gradient">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Geri Yükle
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-3">
                    <?php echo e($teachers->links()); ?>

                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-trash3 d-block"></i>
                    <h5>Silinen öğretmen bulunmuyor</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/teachers/trashed.blade.php ENDPATH**/ ?>
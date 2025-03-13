<?php
    $solutions = app(\Spatie\LaravelErrorSolutions\Actions\GetSolutionsForLatestThrowableAction::class)->execute();
?>

<?php if(count($solutions)): ?>
    <style>
        .solution {
            margin: 1.5rem -1.5rem -1.5rem;
            padding: 1.5rem;
            border-radius: 0 0 8px 8px;
            background-color: #d6eed1;
        }

        .dark .solution {
            background-color: #60755b;
        }

        @media (min-width: 640px) {
            .solution {
                margin: 3rem -3rem -3rem;
                padding: 3rem;
            }
        }

        .solution h2 {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .solution h2 + p {
            font-size: 1.25rem;
        }

        .solution h3 {
            text-transform: uppercase;
            margin-top: 1.5rem;
            font-weight: bold;
            font-size: 0.85rem;
            letter-spacing: 0.015em;
        }

        .solution hr {
            margin: 3.5rem 0 2.5rem;
            border-top: 2px solid #b7d2b1;
        }

        .solution a {
            text-decoration: underline;
        }

        .execute-solution {
            margin-top: 3rem;
        }

        .execute-solution form {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .execute-solution button {
            display: flex;
            align-items: center;
            gap: 1ch;
            font-size: 1.125rem;
            font-weight: 500;
            background-color: #b7d2b1;
            padding: 1rem 1.5rem;
            border-radius: 100px;
            transition: background-color 0.15s ease-in-out;
            white-space: nowrap;
        }

        .execute-solution button:hover {
            background-color: #b0c8aa;
        }

        .dark .execute-solution button {
            background-color: #424b40;
        }

        .dark .execute-solution button:hover {
            background-color: #364233;
        }

        .execute-solution button svg {
            height: 1.2em;
        }

        .solution-provider {
            margin-top: 3rem;
            opacity: 0.8;
            font-size: 0.875rem;
            text-align: right;
        }
    </style>
    <div class="solution">
        <?php $__currentLoopData = $solutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h2><?php echo e($solution->getSolutionTitle()); ?><?php echo e(str_ends_with($solution->getSolutionTitle(), '.') ? '' : '.'); ?></h2>
            <p><?php echo e($solution->getSolutionDescription()); ?></p>

            <?php if(count($solution->getDocumentationLinks())): ?>
                <h3>Read more</h3>
                <ul>
                    <?php $__currentLoopData = $solution->getDocumentationLinks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e($url); ?>" target="_blank" rel="nofollow noreferer">
                                <?php echo e($label); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>

            <?php if(config('error-solutions.enable_runnable_solutions')): ?>
                <?php if($solution instanceof \Spatie\ErrorSolutions\Contracts\RunnableSolution): ?>
                    <div
                        class="execute-solution"
                        x-data="{
                            solutionExecuted: false,
                            submitForm() {
                                this.solutionExecuted = true;

                                fetch('<?php echo e(route('execute-laravel-error-solution')); ?>', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                    },
                                    body: JSON.stringify(<?php echo Js::from([
                                         'solution' => $solution::class
                                     ]); ?>)
                                });
                            }
                        }"
                    >
                        <form x-show="! solutionExecuted" @submit.prevent="submitForm()">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.867 19.125h.008v.008h-.008v-.008Z"/>
                                </svg>
                                <?php echo e($solution->getRunButtonText()); ?>

                            </button>
                            <p><?php echo e($solution->getSolutionActionDescription()); ?></p>
                        </form>

                        <form x-show="solutionExecuted" @submit.prevent="location.reload()">
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                                Refresh page
                            </button>
                            <p>The solution was executed.</p>
                        </form>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(method_exists($solution, 'solutionProvidedByName')): ?>
                <p class="solution-provider">
                    <?php if(method_exists($solution, 'solutionsProvidedByLink')): ?>
                        Solution provided by <a
                            href="<?php echo e($solution->solutionsProvidedByLink()); ?>"><?php echo e($solution->solutionProvidedByName()); ?></a>.
                    <?php else: ?>
                        Solution provided by <?php echo e($solution->solutionProvidedByName()); ?>.
                    <?php endif; ?>
                    <?php if($solution instanceof \Spatie\ErrorSolutions\Solutions\OpenAi\OpenAiSolution): ?>
                        This solution was generated by AI. It might not be 100% accurate.
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <?php if(!$loop->last): ?>
                <hr>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/_bases/base_fixcity_fila3/laravel/vendor/spatie/laravel-error-solutions/resources/views/components/solution.blade.php ENDPATH**/ ?>
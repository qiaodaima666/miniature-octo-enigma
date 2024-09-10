import os
import sys
import unittest
import pylint.lint
import flake8.api.legacy as flake8
import cProfile
import pstats

def check_file_encoding(file_path):
    with open(file_path, 'rb') as f:
        raw = f.read()
        if raw.startswith(codecs.BOM_UTF8):
            print("文件包含BOM头，请移除。")
            return False
    return True

def run_pylint(file_path):
    results = pylint.lint.Run([file_path], do_exit=False)
    print(results.linter.stats['global_note'])

def run_flake8(file_path):
    style_guide = flake8.get_style_guide()
    report = style_guide.check_files([file_path])
    print(report.get_statistics('E'))

def run_unit_tests(test_module):
    suite = unittest.TestLoader().loadTestsFromModule(test_module)
    result = unittest.TextTestRunner(verbosity=2).run(suite)
    if not result.wasSuccessful():
        print("单元测试未通过，请检查代码逻辑。")
        sys.exit(1)

def profile_code(func):
    profiler = cProfile.Profile()
    profiler.enable()
    func()
    profiler.disable()
    stats = pstats.Stats(profiler).sort_stats('cumulative')
    stats.print_stats()

if __name__ == "__main__":
    file_path = "path_to_your_file.py"
    test_module = "path_to_your_test_module"

    if not check_file_encoding(file_path):
        sys.exit(1)

    run_pylint(file_path)
    run_flake8(file_path)
    run_unit_tests(test_module)

    # 假设有一个函数名为main_func需要性能分析
    profile_code(main_func)

import 'package:flutter_bloc/flutter_bloc.dart';
import 'login_state.dart';
import '../../data/repositories/auth_repository.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LoginCubit extends Cubit<LoginState> {
  final AuthRepository repository;

  LoginCubit(this.repository) : super(LoginInitial());

  Future<void> login(String email, String password) async {
    emit(LoginLoading());
    try {
      final result = await repository.login(email, password);

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('accessToken', result.accessToken);

      emit(LoginSuccess());
    } catch (e) {
      emit(LoginFailure('Email atau password salah'));
    }
  }
}

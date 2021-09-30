import { ErrorName } from '../constants';
import { DiagnosticError } from './DiagnosticError';

/**
 * @internalapi
 * Represents when a test in the Diagnostics SDK is an unknown or unexpected
 * state, usually resulting in fatal error.
 */
export class InvalidStateError extends DiagnosticError {
  /**
   * Sets the name to `InvalidStateError`.
   * @param message
   */
  constructor(message?: string) {
    super(undefined, message);

    this.name = ErrorName.InvalidStateError;
  }
}
